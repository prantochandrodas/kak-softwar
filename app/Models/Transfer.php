<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }
    public function formBranch()
    {
        return $this->belongsTo(Branch::class, 'form_branch_id');
    }


    public function details()
    {
        return $this->hasMany(TransferDetails::class, 'transfer_id');
    }
}
