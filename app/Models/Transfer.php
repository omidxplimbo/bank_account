<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfers';
    protected $fillable = ['destination_account_id', 'source_account_id','amount', 'created_at', 'updated_at'];

    public function account()
    {
        return $this->belongsTo(Account::class,'source_account_id','id');
    }
}
