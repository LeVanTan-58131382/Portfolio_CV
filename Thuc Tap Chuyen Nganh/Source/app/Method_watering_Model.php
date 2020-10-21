<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Method_watering_Model extends Model
{
    protected $table = 'method_watering';
    protected $fillable = ['id', 'method'];
}
