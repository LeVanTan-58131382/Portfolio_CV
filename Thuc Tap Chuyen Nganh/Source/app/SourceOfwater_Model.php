<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SourceOfwater_Model extends Model
{
    protected $table = 'water_tanks';
    protected $fillable = ['id', 'name', 'volume', 'farm_id'];
}
