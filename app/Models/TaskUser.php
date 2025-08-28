<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    protected $table = 'task_user'; // Specify the pivot table name
    protected $fillable = ['assigned_by', 'task_id', 'user_id']; // Fillable fields for mass assignment
}
