<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'job_id',
    ];

    public function userTaskFor($id) {
        return $this->userTasks()->where('user_id', $id)->first();
    }
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }
}
