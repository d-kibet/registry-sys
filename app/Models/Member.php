<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'registered_by',
        'constituency_id',
        'first_name',
        'second_name',
        'third_name',
        'full_name',
        'phone_number',
        'id_number',
        'gender',
        'polling_station',
        'ward',
        'verification_proof_path',
        'is_verified',
        'verified_at',
        'latitude',
        'longitude',
        'wants_to_vie',
        'vie_position',
        'registration_ip',
        'user_agent',
        'synced_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'synced_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'wants_to_vie' => 'boolean',
    ];

    /**
     * Get the company that owns the member
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the agent who registered this member
     */
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    /**
     * Get the constituency of the member
     */
    public function constituency()
    {
        return $this->belongsTo(Constituency::class);
    }

    /**
     * Check if member registration was synced from offline
     */
    public function isSynced(): bool
    {
        return !is_null($this->synced_at);
    }

    /**
     * Get formatted phone number for display
     */
    public function getFormattedPhoneAttribute(): string
    {
        // Format as 0712 345 678
        $phone = $this->phone_number;
        if (strlen($phone) === 10 && str_starts_with($phone, '0')) {
            return substr($phone, 0, 4) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7);
        }
        return $phone;
    }

    /**
     * Scope for searching members
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('phone_number', 'like', "%{$search}%")
              ->orWhere('id_number', 'like', "%{$search}%");
        });
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope for filtering by company
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope for filtering by agent
     */
    public function scopeByAgent($query, $agentId)
    {
        return $query->where('registered_by', $agentId);
    }
}
