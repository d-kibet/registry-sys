<?php

namespace App\Observers;

use App\Models\Constituency;
use Illuminate\Support\Facades\Cache;

class ConstituencyObserver
{
    /**
     * Handle the Constituency "created" event.
     */
    public function created(Constituency $constituency): void
    {
        $this->clearConstituencyCache();
    }

    /**
     * Handle the Constituency "updated" event.
     */
    public function updated(Constituency $constituency): void
    {
        $this->clearConstituencyCache();
    }

    /**
     * Handle the Constituency "deleted" event.
     */
    public function deleted(Constituency $constituency): void
    {
        $this->clearConstituencyCache();
    }

    /**
     * Handle the Constituency "restored" event.
     */
    public function restored(Constituency $constituency): void
    {
        $this->clearConstituencyCache();
    }

    /**
     * Handle the Constituency "force deleted" event.
     */
    public function forceDeleted(Constituency $constituency): void
    {
        $this->clearConstituencyCache();
    }

    /**
     * Clear constituency-related caches
     */
    protected function clearConstituencyCache(): void
    {
        // Clear constituencies list cache
        Cache::forget('constituencies.all');

        // Clear constituency stats cache
        Cache::forget('stats.constituencies');
    }
}
