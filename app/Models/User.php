<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->user_type === 'super_admin';
    }

    public function isClient(): bool
    {
        return $this->user_type === 'client';
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')
            ->withPivot('company_id')
            ->withTimestamps();
    }

    public function hasPermission(string $permissionSlug, ?int $companyId = null): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $companyId = $companyId ?? $this->company_id;

        return $this->permissions()
            ->where('permissions.slug', $permissionSlug)
            ->wherePivot('company_id', $companyId)
            ->exists();
    }

    public function hasModuleAccess(string $moduleSlug, ?int $companyId = null): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $companyId = $companyId ?? $this->company_id;
        $company = Company::find($companyId);

        if (!$company) {
            return false;
        }

        return $company->modules()
            ->where('modules.slug', $moduleSlug)
            ->wherePivot('is_active', true)
            ->exists();
    }

    public function hasSubmoduleAccess(string $submoduleSlug, ?int $companyId = null): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $companyId = $companyId ?? $this->company_id;
        $company = Company::find($companyId);

        if (!$company) {
            return false;
        }

        return $company->submodules()
            ->where('submodules.slug', $submoduleSlug)
            ->wherePivot('is_active', true)
            ->exists();
    }
}
