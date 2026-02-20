<?php

namespace App\Models\Traits;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasNotifications
{
    /**
     * Get all notifications for the user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class)->latest();
    }

    /**
     * Get unread notifications.
     */
    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(Notification::class)->where('is_read', false)->latest();
    }

    /**
     * Get read notifications.
     */
    public function readNotifications(): HasMany
    {
        return $this->hasMany(Notification::class)->where('is_read', true)->latest();
    }

    /**
     * Get unread notifications count.
     */
    public function getUnreadNotificationsCountAttribute(): int
    {
        return $this->notifications()->unread()->count();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsAsRead(): void
    {
        $this->notifications()->unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Delete all read notifications.
     */
    public function deleteReadNotifications(): void
    {
        $this->notifications()->read()->delete();
    }
}
