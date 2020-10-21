<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weather_Conditions_Model extends Model
{
    protected $table = 'weather_conditions';
    protected $fillable = ['id', 'humidity_from','humidity_to', 'temperature_from', 'temperature_to', 'light', 'land_id', 'ph'];
}
