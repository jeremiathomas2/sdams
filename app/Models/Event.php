<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'location', 'start_time', 'end_time', 'type'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
