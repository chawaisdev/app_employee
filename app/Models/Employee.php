<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
class Employee extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    protected $table = 'employees';
    
    protected $fillable = [
        'full_name', 'guardian_name', 'dob', 'gender', 'cnic', 'phone', 'email',
        'emergency_contact_name', 'emergency_contact_phone', 'current_address',
        'permanent_address', 'user_type', 'photo_path', 'cv_path', 'designation_id',
        'joining_date', 'employment_type', 'salary_amount', 'shift_name', 'shift_start',
        'shift_end', 'education_level', 'university_college', 'internship_department',
        'is_password_update','is_profile_update',
        'internship_start', 'internship_end', 'internship_duration', 'stipend', 'stipend_amount', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employee_project', 'employee_id', 'project_id');
    }
}
