<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seasons_Details_Model extends Model
{
    protected $table = 'seasons_details';
    protected $fillable = ['id', 'crop_id', 'season_id'];
}
