<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'full_name',
        'guardian_name',
        'dob',
        'gender',
        'cnic',
        'phone',
        'email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'current_address',
        'permanent_address',
        'photo_path',
        'enrollment_date',
        'course_program',
        'batch_session',
        'duration',
        'fee_amount',
        'payment_status',
        'education_level',
        'university_college',
    ];
}
