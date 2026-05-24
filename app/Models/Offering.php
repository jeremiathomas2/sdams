<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{
    protected $fillable = ['member_id', 'amount', 'type', 'date', 'receipt_number', 'fund_id', 'notes'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
}
