<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function salary($teacher_id)
    {
        $groups = Group::where('teacher_id', $teacher_id)
            ->where('payments.status',true)
            ->Join('payments', 'payments.group_id', '=', 'groups.id')
            ->get();
        $totalSum = 0;
        foreach ($groups as $group){
            $totalSum += $group->amount * $group->teacher_part;
        }
        return $totalSum;
    }

}
