<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watering_Details_Model extends Model
{
    protected $table = 'watering_details';
    protected $fillable = ['id', 'water_volume', 'land_id', 'water_tank_id','deleted', 'method_id'];
}
