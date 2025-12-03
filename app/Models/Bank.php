<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function fund()
    {
        return $this->belongsTo(Fund::class, 'fund_id');
    }
}