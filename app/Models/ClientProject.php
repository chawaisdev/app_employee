<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientProject extends Model
{
    protected $table = 'client_project';
    protected $fillable = ['user_id', 'project_id'];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
