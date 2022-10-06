<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organization_id',
        'active'
    ];

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }
}
