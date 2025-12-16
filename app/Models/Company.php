<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all users belonging to this company
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all members registered by this company's agents
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get the constituencies assigned to this company
     */
    public function constituencies()
    {
        return $this->belongsToMany(Constituency::class);
    }

    /**
     * Get company admins only
     */
    public function admins()
    {
        return $this->users()->role('Company Admin');
    }

    /**
     * Get company agents only
     */
    public function agents()
    {
        return $this->users()->role('Agent');
    }

    /**
     * Scope to get only active companies
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
