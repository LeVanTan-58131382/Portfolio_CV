<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lands_Model extends Model
{
    protected $table = 'lands';
    protected $fillable = ['id', 'name', 'quanty_crops', 'square', 'dev_days', 'crop_id', 'have_watered', 'have_fertilized','farm_id', 'deleted', 'have_decreased_pH', 'have_increased_pH'];
    // một land có nhiều lần tưới nước
    public function Seasons_Details()
    {
     	return $this->hasMany('App\Watering_Details_Model','land_id');
    }
    // một land có nhiều lần tưới phân
    public function Fertilizer_Details()
    {
     	return $this->hasMany('App\Fertilizer_Details_Model','land_id');
    }
    // một land có một điều kiện môi trường
    public function Weather_Conditions()
    {
     	return $this->hasMany('App\Weather_Conditions_Model','land_id');
    }

}
