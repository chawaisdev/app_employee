<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    protected $table = 'task_user';
    protected $fillable = ['assigned_by', 'task_id', 'employee_id'];

    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
