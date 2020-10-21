<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow_fer_Model extends Model
{
    protected $table = 'follow_fer';
    protected $fillable = ['id', 'id_land', 'numerical_order', 'have_fer'];
}
