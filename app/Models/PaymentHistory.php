<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'addBy',
        'date'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function addByUser(){
        return $this->belongsTo(User::class,'addBy','id');
    }
}
