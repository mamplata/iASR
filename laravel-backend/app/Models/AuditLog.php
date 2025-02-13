<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'change',
        'content',
        'user',
        'timestamp'
    ];

    protected $casts = [
        'change' => 'array',
        'content' => 'array',
        'timestamp' => 'datetime'
    ];
}
