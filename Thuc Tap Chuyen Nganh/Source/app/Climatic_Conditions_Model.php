<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Climatic_Conditions_Model extends Model
{
    protected $table = 'climatic_conditions';
    protected $fillable = ['id', 'name', 'description'];

    public function Climatic_Condition_Details()
    {
     	return $this->hasMany('App\Climatic_Condition_Details_Model','crop_id');
    }
}
