<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_name',
        'teacher_id',
        'payment',
        'teacher_part',
        'status'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id','id');
    }

    public function group_to_students()
    {
        return $this->hasMany(GroupToStudent::class, 'group_id', 'id');
    }
}
