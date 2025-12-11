<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function customer()
    {
        return $this->belongsTo(CustomerInformation::class, 'customer_id');
    }

    public function details()
    {
        return $this->hasMany(SaleDetails::class, 'sale_id');
    }
    public function payments()
    {
        return $this->hasMany(SalePayment::class, 'sale_id');
    }
}