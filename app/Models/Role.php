<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'label', 'description'];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->label ?: $this->name;
    }

    public function getUserCountAttribute(): int
    {
        return User::where('role', $this->name)->count();
    }

    public function getPermissionNamesAttribute(): array
    {
        return $this->permissions->pluck('name')->all();
    }
}
