<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'comment',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}