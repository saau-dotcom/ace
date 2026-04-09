<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Lead extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'suburb',
        'post_code',
        'status',
        'service_type',
        'lead_source',
        'existing_system_installed',
        'requirements',
        'battery_model',
        'inverter_model',
        'panel_model',
        'system_size_kw',
        'battery_capacity_kwh',
        'stc_claimable',
    ];

    protected static function booted(): void
    {
        // Temporary bypass for testing visibility
        // static::addGlobalScope('assignedToUser', function (Builder $builder) {
        //     if (auth()->check() && auth()->user()->role !== 'admin') {
        //         $builder->where('user_id', auth()->id());
        //     }
        // });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'lead_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(LeadDocument::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(LeadTask::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class);
    }
}