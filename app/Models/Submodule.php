<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submodule extends Model
{
    protected $fillable = [
        'module_id',
        'name',
        'slug',
        'route',
        'icon',
        'description',
        'order',
        'is_active',
        'config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class)->where('type', 'submodule');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_submodules')
            ->withPivot('config', 'is_active')
            ->withTimestamps();
    }
}
