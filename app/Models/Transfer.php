<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'type', 'from_church', 'to_church', 'status', 'request_date', 'approval_date', 'notes'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
