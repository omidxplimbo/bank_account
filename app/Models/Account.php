<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $fillable = ['owner','deposit_amount','created_at','updated_at'];

    public function transfersTo()
    {
        return $this->hasMany(Transfer::class,'source_account_id','id');
    }

    public function transfersFrom()
    {
        return $this->hasMany(Transfer::class,'destination_account_id','id');
    }
}
