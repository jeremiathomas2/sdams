<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'balance'];

    public function offerings()
    {
        return $this->hasMany(Offering::class);
    }
}
