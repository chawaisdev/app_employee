<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'images', 'employee_id', 'project_id'];

    protected $casts = [
        'images' => 'array',
    ];

    // Task creator (single employee)
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Assigned employees (many-to-many)
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'task_user', 'task_id', 'employee_id')
                    ->withPivot('status', 'assigned_by')
                    ->withTimestamps();
    }


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}