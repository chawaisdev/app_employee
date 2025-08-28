<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'images', 'user_id', 'project_id'];

    protected $casts = [
        'images' => 'array',
    ];

    // Relationship with the creator (User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user')
                    ->withPivot('status', 'assigned_by')
                    ->withTimestamps();
    }


   public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }


}