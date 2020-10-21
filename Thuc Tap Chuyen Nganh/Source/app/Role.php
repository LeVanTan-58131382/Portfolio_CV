<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use App\User;
class Role extends Model
{
	protected $table = 'roles';
    protected $fillable = ['id', 'name', 'description'];
	public function users()
	{
		return $this->belongsToMany(User::class);
	}
}
