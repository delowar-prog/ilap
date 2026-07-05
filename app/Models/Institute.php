<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = [
        'name',
        'code',
        'eiin',
        'registration_number',
        'institute_type',
        'logo',
        'institute_images',
        'phone',
        'email',
        'website',
        'established_year',
        'country',
        'state',
        'city',
        'postal_code',
        'address',
        'status'
    ];

    protected $casts = [
        'institute_images' => 'array',
    ];
}
