<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constituency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'county',
    ];

    /**
     * Get all members from this constituency
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get all companies assigned to this constituency
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    /**
     * Get members count for this constituency
     */
    public function getMembersCountAttribute()
    {
        return $this->members()->count();
    }

    /**
     * Scope to filter by county
     */
    public function scopeByCounty($query, $county)
    {
        return $query->where('county', $county);
    }
}
