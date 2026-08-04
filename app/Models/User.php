<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'member_id', 'profile_photo_path'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function roleModel(): ?Role
    {
        return Role::where('name', $this->role)->first();
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->role === 'Administrator') {
            return true;
        }

        $role = $this->roleModel();

        if ($role) {
            return $role->permissions->contains('name', $permission);
        }

        return in_array($permission, config('roles.defaults.' . $this->role, []), true);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function getMemberIdDisplayAttribute(): string
    {
        return $this->member?->member_id ?? '—';
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : null;
    }

    public function getHasPhotoAttribute(): bool
    {
        return (bool) $this->profile_photo_path;
    }

    public function getInitialsAttribute(): string
    {
        $name = trim($this->name);

        return strtoupper($name === '' ? 'U' : substr($name, 0, 2));
    }

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
}
