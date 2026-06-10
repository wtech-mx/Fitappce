<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'parent_category',
    'category',
    'subcategory',
    'level',
    'primary_muscle',
    'muscles',
    'description',
    'purpose',
    'coach_notes',
    'common_mistakes',
    'demo_type',
    'demo_source',
    'demo_path',
    'demo_url',
    'allows_evidence',
    'is_featured',
    'is_active',
])]
class Exercise extends Model
{
    protected function casts(): array
    {
        return [
            'allows_evidence' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function workoutPlanExercises(): HasMany
    {
        return $this->hasMany(WorkoutPlanExercise::class);
    }

    public function demoUrl(): ?string
    {
        if ($this->demo_source === 'url') {
            return $this->demo_url;
        }

        return $this->demo_path ? asset($this->demo_path) : null;
    }

    public function demoEmbedUrl(): ?string
    {
        if ($this->demo_source !== 'url' || blank($this->demo_url)) {
            return null;
        }

        $url = $this->demo_url;
        $host = parse_url($url, PHP_URL_HOST) ?: '';

        if (str_contains($host, 'youtu.be')) {
            $id = trim(parse_url($url, PHP_URL_PATH) ?: '', '/');

            return $id ? "https://www.youtube.com/embed/{$id}" : null;
        }

        if (str_contains($host, 'youtube.com')) {
            parse_str(parse_url($url, PHP_URL_QUERY) ?: '', $query);
            $id = $query['v'] ?? null;

            if (! $id && str_contains($url, '/shorts/')) {
                $id = str($url)->after('/shorts/')->before('?')->before('/')->toString();
            }

            return $id ? "https://www.youtube.com/embed/{$id}" : null;
        }

        if (str_contains($host, 'drive.google.com')) {
            $path = parse_url($url, PHP_URL_PATH) ?: '';

            if (preg_match('#/file/d/([^/]+)#', $path, $matches)) {
                return "https://drive.google.com/file/d/{$matches[1]}/preview";
            }
        }

        return null;
    }

    public function taxonomyLabel(): string
    {
        return collect([$this->parent_category, $this->category, $this->subcategory])
            ->filter()
            ->join(' - ');
    }
}
