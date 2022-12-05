<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rule_id'
    ];

    public function rule()
    {
        return $this->hasOne(Rule::class, 'id', 'rule_id');
    }
}
