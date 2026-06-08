<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\ClientAchievement;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AchievementController extends Controller
{
    public function index(Request $request): View
    {
        $achievements = Achievement::withCount(['clientAchievements as unlocked_count' => fn ($query) => $query->whereNotNull('unlocked_at')])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('goal_text', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('fitapp.admin.logros', compact('achievements', 'users'));
    }

    public function create(): View
    {
        return view('fitapp.admin.logros-crear', [
            'achievement' => null,
            'mode' => 'create',
            'categories' => Achievement::categoryOptions(),
            'triggers' => Achievement::triggerOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedAchievement($request);
        $validated['image_path'] = $this->storeImage($request);
        $validated['is_active'] = $request->boolean('is_active');

        $achievement = Achievement::create($validated);

        return redirect()
            ->route('fitapp.admin.logros')
            ->with('status', "Logro {$achievement->name} creado correctamente.");
    }

    public function edit(Achievement $achievement): View
    {
        return view('fitapp.admin.logros-crear', [
            'achievement' => $achievement,
            'mode' => 'edit',
            'categories' => Achievement::categoryOptions(),
            'triggers' => Achievement::triggerOptions(),
        ]);
    }

    public function update(Request $request, Achievement $achievement): RedirectResponse
    {
        $validated = $this->validatedAchievement($request);

        if ($imagePath = $this->storeImage($request)) {
            $validated['image_path'] = $imagePath;
        }

        $validated['is_active'] = $request->boolean('is_active');
        $achievement->update($validated);

        return redirect()
            ->route('fitapp.admin.logros')
            ->with('status', "Logro {$achievement->name} actualizado correctamente.");
    }

    public function unlock(Request $request, Achievement $achievement): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'source_note' => ['nullable', 'string', 'max:160'],
        ]);

        ClientAchievement::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'achievement_id' => $achievement->id,
            ],
            [
                'progress_value' => $achievement->target_count ?: 1,
                'unlocked_at' => now(),
                'source_note' => $validated['source_note'] ?? 'Desbloqueado por el coach',
            ]
        );

        return back()->with('status', "Logro {$achievement->name} desbloqueado para el cliente.");
    }

    private function validatedAchievement(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'in:'.implode(',', array_keys(Achievement::categoryOptions()))],
            'goal_text' => ['required', 'string', 'max:1000'],
            'trigger_type' => ['required', 'in:'.implode(',', array_keys(Achievement::triggerOptions()))],
            'target_count' => ['nullable', 'integer', 'min:1', 'max:999'],
            'target_unit' => ['nullable', 'string', 'max:80'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $directory = public_path('fitapp/img/achievements');
        File::ensureDirectoryExists($directory);

        $file = $request->file('image');
        $filename = uniqid('achievement_', true).'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'fitapp/img/achievements/'.$filename;
    }
}
