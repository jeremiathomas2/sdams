<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'member_id',
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
}
