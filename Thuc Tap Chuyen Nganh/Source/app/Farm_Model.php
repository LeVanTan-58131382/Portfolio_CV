<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Farm_Model extends Model
{
    protected $table = 'farm';
    protected $fillable = ['id', 'name', 'cultivated_area', 'season_id', 'clim_Conditions_id', 'current_month','planted_area', 'vacant_area'];
}
