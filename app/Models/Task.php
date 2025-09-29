<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'images', 'employee_id', 'project_id', 'is_status'];

    protected $casts = [
        'images' => 'array',
    ];

    // Task creator (single employee)
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assets()
    {
        return $this->hasMany(TaskAsset::class);
    }
}