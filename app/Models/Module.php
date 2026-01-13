<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'name',
        'slug',
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

    public function submodules(): HasMany
    {
        return $this->hasMany(Submodule::class)->orderBy('order');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class)->where('type', 'module');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_modules')
            ->withPivot('config', 'is_active')
            ->withTimestamps();
    }
}
