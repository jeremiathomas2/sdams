<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offering extends Model
{
    use HasFactory;

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
