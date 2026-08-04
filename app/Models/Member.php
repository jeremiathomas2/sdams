<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'member_id',
    'photo_path',
    'first_name',
    'middle_name',
    'last_name',
    'date_of_birth',
    'gender',
    'marital_status',
    'phone_number',
    'email',
    'residential_address',
    'baptism_date',
    'membership_class',
    'membership_status',
    'department_ministry'
])]
class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    public function offerings()
    {
        return $this->hasMany(Offering::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path
            ? asset('storage/' . $this->photo_path)
            : null;
    }

    public function getHasPhotoAttribute(): bool
    {
        return (bool) $this->photo_path;
    }

    public function getInitialsAttribute(): string
    {
        $first = $this->first_name[0] ?? '';
        $last = $this->last_name[0] ?? '';

        return strtoupper($first . $last);
    }
}
