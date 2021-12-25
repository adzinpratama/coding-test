<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'type',
    	'balance',
    	'fee_admin',
    	'status',
    	'data',
    	'total_amount'
    ];

    protected $casts = [
    	'data' => 'array'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function logs(){
    	return $this->hasMany(TransactionLog::class);
    }
}
