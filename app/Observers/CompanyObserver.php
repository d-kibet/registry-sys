<?php

namespace App\Observers;

use App\Models\Company;
use Illuminate\Support\Facades\Cache;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        $this->clearCompanyCache($company);
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        $this->clearCompanyCache($company);
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        $this->clearCompanyCache($company);
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        $this->clearCompanyCache($company);
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        $this->clearCompanyCache($company);
    }

    /**
     * Clear company-related caches
     */
    protected function clearCompanyCache(Company $company): void
    {
        // Clear active companies list cache
        Cache::forget('companies.active');

        // Clear global stats cache
        Cache::forget('stats.global');

        // Clear company-specific caches
        Cache::forget("company.{$company->id}.stats");
        Cache::forget("company.{$company->id}.agents");
        Cache::forget("company.{$company->id}.constituencies");
    }
}
