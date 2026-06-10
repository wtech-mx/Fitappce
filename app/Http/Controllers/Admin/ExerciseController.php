<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ExerciseController extends Controller
{
    public function index(Request $request): View
    {
        $exercises = Exercise::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('subcategory', 'like', "%{$search}%")
                        ->orWhere('primary_muscle', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $taxonomy = $exercises
            ->groupBy(fn (Exercise $exercise) => $exercise->parent_category ?: 'Sin categoria padre')
            ->map(fn ($group) => $group
                ->groupBy(fn (Exercise $exercise) => $exercise->category ?: 'Sin categoria')
                ->map(fn ($items) => $items->pluck('subcategory')->filter()->unique()->values()));

        return view('fitapp.admin.ejercicios', compact('exercises', 'taxonomy'));
    }

    public function create(): View
    {
        return view('fitapp.admin.ejercicios-crear', [
            'exercise' => null,
            'mode' => 'create',
            'options' => $this->options(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedExercise($request);
        $validated['demo_path'] = $validated['demo_source'] === 'upload' ? $this->storeDemo($request) : null;
        $validated['demo_url'] = $validated['demo_source'] === 'url' ? $validated['demo_url'] : null;
        $validated += $this->booleanPayload($request);

        $exercise = Exercise::create($validated);

        return redirect()
            ->route('fitapp.admin.ejercicios.detalle', $exercise)
            ->with('status', "Ejercicio {$exercise->name} guardado correctamente.");
    }

    public function show(Exercise $exercise): View
    {
        return view('fitapp.admin.ejercicio-detalle', compact('exercise'));
    }

    public function edit(Exercise $exercise): View
    {
        return view('fitapp.admin.ejercicios-crear', [
            'exercise' => $exercise,
            'mode' => 'edit',
            'options' => $this->options(),
        ]);
    }

    public function update(Request $request, Exercise $exercise): RedirectResponse
    {
        $validated = $this->validatedExercise($request);

        if ($validated['demo_source'] === 'upload' && $demoPath = $this->storeDemo($request)) {
            $validated['demo_path'] = $demoPath;
        }

        if ($validated['demo_source'] === 'url') {
            $validated['demo_path'] = null;
        } else {
            $validated['demo_url'] = null;
        }

        $validated += $this->booleanPayload($request);
        $exercise->update($validated);

        return redirect()
            ->route('fitapp.admin.ejercicios.detalle', $exercise)
            ->with('status', "Ejercicio {$exercise->name} actualizado correctamente.");
    }

    private function validatedExercise(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'parent_category' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:120'],
            'subcategory' => ['nullable', 'string', 'max:120'],
            'level' => ['nullable', 'string', 'max:80'],
            'primary_muscle' => ['nullable', 'string', 'max:120'],
            'muscles' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'purpose' => ['nullable', 'string', 'max:1000'],
            'coach_notes' => ['nullable', 'string', 'max:2000'],
            'common_mistakes' => ['nullable', 'string', 'max:2000'],
            'demo_type' => ['required', 'in:video,gif,image'],
            'demo_source' => ['required', 'in:upload,url'],
            'demo_url' => ['nullable', 'url', 'max:500'],
            'demo' => ['nullable', 'file', 'mimes:mp4,mov,webm,gif,jpg,jpeg,png', 'max:51200'],
        ]);
    }

    private function booleanPayload(Request $request): array
    {
        return [
            'allows_evidence' => $request->boolean('allows_evidence'),
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ];
    }

    private function storeDemo(Request $request): ?string
    {
        if (! $request->hasFile('demo')) {
            return null;
        }

        $directory = public_path('fitapp/media/exercises');
        File::ensureDirectoryExists($directory);

        $file = $request->file('demo');
        $filename = uniqid('exercise_', true).'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'fitapp/media/exercises/'.$filename;
    }

    private function options(): array
    {
        return [
            'parents' => Exercise::query()->pluck('parent_category')->filter()->unique()->sort()->values(),
            'categories' => Exercise::query()->pluck('category')->filter()->unique()->sort()->values(),
            'subcategories' => Exercise::query()->pluck('subcategory')->filter()->unique()->sort()->values(),
            'levels' => ['Principiante', 'Intermedio', 'Avanzado'],
        ];
    }
}
