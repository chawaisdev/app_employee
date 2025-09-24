<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

}
