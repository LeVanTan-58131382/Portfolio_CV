<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_Fertilizers_Model extends Model
{
    protected $table = 'type_fertilizers';
    protected $fillable = ['id', 'name'];
    // một loại phân bón thì có nhiều phân bón
    public function Fertilizers()
    {
     	return $this->hasMany('App\Fertilizers_Model','fertilizer_id');
    }
}
