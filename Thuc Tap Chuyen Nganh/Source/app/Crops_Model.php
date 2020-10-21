<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crops_Model extends Model
{
    protected $table = 'crops';
    protected $fillable = ['id', 'name', 'density', 'description', 'image', 'quantity_max_stages_dev', 'pests_and_diseases'];
    // một loại cây trồng có nhiều giai đoạn phát triển
    public function Stages_dev()
    {
     	return $this->hasMany('App\Stages_dev_Model','crop_id');
    }
    // một loại cây trồng có nhiều chi tiết mùa vụ
    public function Seasons_Details()
    {
     	return $this->hasMany('App\Seasons_Details_Model','crop_id');
    }

    // một loại cây trồng có nhiều điều kiện khí hậu khác nhau (trồng dc)
    public function Climatic_Condition_Details()
    {
     	return $this->hasMany('App\Climatic_Condition_Details_Model','crop_id');
    }
}
