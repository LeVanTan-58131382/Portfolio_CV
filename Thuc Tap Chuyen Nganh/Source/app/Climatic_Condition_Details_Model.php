<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Climatic_Condition_Details_Model extends Model
{
    protected $table = 'climatic_condition_details';
    protected $fillable = ['id', 'crop_id', 'Clim_Conditions_id'];
    // một chi tiết điều kiện khí hậu thuộc một điều kiện khí hậu
    public function Climatic_Condition()
    {
     	return $this->bolongsTo('App\Climatic_Conditions_Model','Clim_Conditions_id');
    }
    // một chi tiết điều kiện khí hậu thuộc một loại cây
    public function Crops()
    {
     	return $this->bolongsTo('App\Crops_Model','crop_id');
    }
}
