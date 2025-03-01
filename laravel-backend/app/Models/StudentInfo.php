<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'uid',
        'first_name',
        'last_name',
        'program',
        'department',
        'year_level',
    ];
}
