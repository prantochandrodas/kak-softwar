<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundTransfer extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }
    public function formBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function fromFund()
    {
        return $this->belongsTo(Fund::class, 'from_fund_id');
    }

    public function fromBank()
    {
        return $this->belongsTo(Bank::class, 'from_bank_id');
    }

    public function fromAccount()
    {
        return $this->belongsTo(BankAccount::class, 'from_acc_id');
    }
    public function toFund()
    {
        return $this->belongsTo(Fund::class, 'to_fund_id');
    }

    public function toBank()
    {
        return $this->belongsTo(Bank::class, 'to_bank_id');
    }

    public function toAccount()
    {
        return $this->belongsTo(BankAccount::class, 'to_acc_id');
    }
}