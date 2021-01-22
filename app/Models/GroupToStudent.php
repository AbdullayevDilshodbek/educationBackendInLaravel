<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupToStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'group_id',
        'credit',
        'discount',
        'status',
        'change_group_date',
        'pay_part'
    ];

    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }
}
