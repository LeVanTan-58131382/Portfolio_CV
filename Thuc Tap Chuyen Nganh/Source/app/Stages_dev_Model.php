<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stages_dev_Model extends Model
{
    protected $table = 'stages_dev';
    protected $fillable = ['id', 'numerical_order', 'name', 'start_day', 'end_day', 'fertilizer', 'fertilizer_mass', 'water_volume', 'crop_id','have_fertilized'];
}
