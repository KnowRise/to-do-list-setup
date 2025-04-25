<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'password',
        'profile',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function userTasks() {
        return $this->hasMany(UserTask::class);
    }

    public function jobs() {
        return $this->hasMany(Job::class);
    }
}
