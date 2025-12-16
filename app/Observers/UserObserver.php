<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->clearUserCache($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $this->clearUserCache($user);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->clearUserCache($user);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $this->clearUserCache($user);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        $this->clearUserCache($user);
    }

    /**
     * Clear user-related caches
     */
    protected function clearUserCache(User $user): void
    {
        // Clear global stats cache
        Cache::forget('stats.global');

        // If user has a company, clear company caches
        if ($user->company_id) {
            Cache::forget("company.{$user->company_id}.stats");
            Cache::forget("company.{$user->company_id}.agents");
        }
    }
}
