<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seasons_Model extends Model
{
    protected $table = 'seasons';
    protected $fillable = ['id', 'name','description', 'start_month_planting','end_month_planting','crop_id'];

}
