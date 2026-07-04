<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id', 'state_id', 'name', 'city_code', 'status'
    ];

    public function country() { return $this->belongsTo(Country::class); }
    public function state() { return $this->belongsTo(State::class); }
}