<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NFCCard extends Model
{
    use HasFactory;

    protected $table = 'nfc_cards';

    protected $fillable = [
        'uid',
        'student_id',
    ];
}
