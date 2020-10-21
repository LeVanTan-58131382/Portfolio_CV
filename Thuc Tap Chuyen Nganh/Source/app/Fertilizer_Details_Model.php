<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fertilizer_Details_Model extends Model
{
    protected $table = 'fertilizer_details';
    protected $fillable = ['id', 'land_id', 'fertilizer_id','type_fertilizer_id','mass','deleted'];
}
