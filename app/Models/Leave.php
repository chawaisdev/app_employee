<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{

    protected $fillable = [
        'type', 'start_date', 'end_date', 'note', 'document', 'status'
    ];

     public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
