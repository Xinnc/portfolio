<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'instagram',
        'telegram',
        'whatsapp',
        'max',
        'vk',
    ];
}
