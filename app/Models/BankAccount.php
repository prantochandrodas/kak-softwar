<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function bankBranch()
    {
        return $this->belongsTo(BankBranch::class, 'bank_branch_id');
    }
}