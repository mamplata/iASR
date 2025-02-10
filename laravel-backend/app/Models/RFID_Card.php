<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RFID_Card extends Model
{

    protected $primaryKey = 'cardId';

    protected $fillable = [
        'uid',
        'deviceId',
        'studName',
        'program',
        'department',
        'yearLevel'
    ];
}
