<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'title',
        'contact_info',
        'contact_form',
        'contact_map',
        'mail_subject',
        'is_copy',
        'is_publish',
    ];
}
