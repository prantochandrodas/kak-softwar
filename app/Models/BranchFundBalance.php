<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchFundBalance extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function fund()
    {
        return $this->belongsTo(Fund::class, 'fund_id');
    }
    public function account()
    {
        return $this->belongsTo(BankAccount::class, 'account_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
