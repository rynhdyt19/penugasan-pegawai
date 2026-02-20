<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'icon',
        'url',
        'is_read',
        'read_at',
    ];


    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Scope untuk notifikasi yang belum dibaca.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope untuk notifikasi yang sudah dibaca.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Get icon class based on type.
     */
    public function getIconClassAttribute(): string
    {
        if ($this->icon) {
            return $this->icon;
        }

        return match ($this->type) {
            'success' => 'text-green-500',
            'warning' => 'text-yellow-500',
            'danger' => 'text-red-500',
            default => 'text-blue-500',
        };
    }

    /**
     * Get background class based on type.
     */
    public function getBgClassAttribute(): string
    {
        return match ($this->type) {
            'success' => 'bg-green-50',
            'warning' => 'bg-yellow-50',
            'danger' => 'bg-red-50',
            default => 'bg-blue-50',
        };
    }
}
