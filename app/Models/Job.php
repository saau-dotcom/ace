<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Job extends Model
{
    protected $table = 'installations';
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope('assignedToInstaller', function (Builder $builder) {
            // Note: Installers should only see their jobs. Sales might see their lead's jobs. Simple logic here.
            if (auth()->check() && auth()->user()->role === 'installer') {
                $builder->where('assigned_installer_id', auth()->id());
            }
        });
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function installer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_installer_id');
    }

    protected $casts = [
        'scheduled_date' => 'date',
    ];
}