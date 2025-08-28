<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $table = 'employees';
    protected $fillable = [
        'full_name', 'guardian_name', 'dob', 'gender', 'cnic', 'phone', 'email',
        'emergency_contact_name', 'emergency_contact_phone', 'current_address',
        'permanent_address', 'user_type', 'photo_path', 'cv_path', 'designation_id',
        'joining_date', 'employment_type', 'salary_amount', 'shift_name', 'shift_start',
        'shift_end', 'education_level', 'university_college', 'internship_department',
        'internship_start', 'internship_end', 'internship_duration', 'stipend', 'stipend_amount', 'password'
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
