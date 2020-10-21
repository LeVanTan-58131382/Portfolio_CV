<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fertilizers_Model extends Model
{
    protected $table = 'fertilizers';
    protected $fillable = ['id', 'name', 'mass', 'type_fertilizer_id', 'farm_id','description', 'mass_reduces_1_pH_above_30_m', 'mass_increase_1_pH_above_30_m', 'effective_time', 'mass_suiable_30_m'];
}
