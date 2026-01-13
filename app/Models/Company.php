<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'company_modules')
            ->withPivot('config', 'is_active')
            ->withTimestamps();
    }

    public function submodules(): BelongsToMany
    {
        return $this->belongsToMany(Submodule::class, 'company_submodules')
            ->withPivot('config', 'is_active')
            ->withTimestamps();
    }
}
