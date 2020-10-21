<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow_Model extends Model
{
    protected $table = 'follow';
    protected $fillable = ['id', 'id_land', 'total_water', 'total_fer', 'day_harvest', 'old'];
}
