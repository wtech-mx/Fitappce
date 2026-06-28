<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'created_by',
        'kind',
        'title',
        'appointment_type',
        'modality',
        'payment_method',
        'status',
        'starts_at',
        'ends_at',
        'duration_minutes',
        'location',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'duration_minutes' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeAppointments(Builder $query): Builder
    {
        return $query->where('kind', 'appointment');
    }

    public function scopeBlocks(Builder $query): Builder
    {
        return $query->where('kind', 'block');
    }

    public function scopeOverlapping(Builder $query, string $startsAt, string $endsAt, ?int $ignoreId = null): Builder
    {
        return $query
            ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
            ->where('starts_at', '<', $endsAt)
            ->where('ends_at', '>', $startsAt)
            ->whereNotIn('status', ['cancelled', 'completed']);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'scheduled' => 'Agendada',
            'confirmed' => 'Confirmada',
            'in_progress' => 'En curso',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada',
            'blocked' => 'Bloqueado',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function statusClass(): string
    {
        return match ($this->status) {
            'confirmed', 'scheduled', 'in_progress' => 'blue',
            'blocked' => 'red',
            'cancelled' => 'red',
            default => '',
        };
    }
}
