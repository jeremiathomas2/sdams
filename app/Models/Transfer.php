<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = ['member_id', 'type', 'from_church', 'to_church', 'status', 'request_date', 'approval_date', 'notes'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
