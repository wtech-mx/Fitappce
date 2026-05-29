<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientMeasurement extends Model
{
    protected $fillable = [
        'user_id',
        'measured_at',
        'appointment_type',
        'weight',
        'body_fat',
        'lean_mass',
        'fat_mass',
        'waist',
        'chest',
        'hip',
        'arm',
        'thigh',
        'calf',
        'target_body_fat',
        'target_weight',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'measured_at' => 'date',
            'weight' => 'decimal:2',
            'body_fat' => 'decimal:2',
            'lean_mass' => 'decimal:2',
            'fat_mass' => 'decimal:2',
            'waist' => 'decimal:2',
            'chest' => 'decimal:2',
            'hip' => 'decimal:2',
            'arm' => 'decimal:2',
            'thigh' => 'decimal:2',
            'calf' => 'decimal:2',
            'target_body_fat' => 'decimal:2',
            'target_weight' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
