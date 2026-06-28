<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressPhoto extends Model
{
    protected $fillable = [
        'user_id',
        'appointment_id',
        'image_path',
        'original_name',
        'original_size',
        'optimized_size',
        'width',
        'height',
        'mime_type',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'original_size' => 'integer',
            'optimized_size' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function imageUrl(): string
    {
        return asset($this->image_path);
    }

    public function savedPercent(): int
    {
        if (! $this->original_size || ! $this->optimized_size || $this->optimized_size >= $this->original_size) {
            return 0;
        }

        return (int) round((1 - ($this->optimized_size / $this->original_size)) * 100);
    }
}
