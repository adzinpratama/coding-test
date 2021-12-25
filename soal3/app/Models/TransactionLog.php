<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
    	'transaction_id',
    	'previous_balance',
    	'current_balance',
    	'status',
    	'data'
    ];


    protected $casts = [
    	'data' => 'array'
    ];


    public function transaction(){
    	return $this->belongsTo(Transaction::class);
    }
}
