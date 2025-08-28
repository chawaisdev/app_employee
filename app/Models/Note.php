<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes'; // Specify the table name if it's not the plural of the model name
    protected $fillable = ['content', 'images'];


    protected $casts = [
        'images' => 'array', // auto convert json to array
    ];
}
