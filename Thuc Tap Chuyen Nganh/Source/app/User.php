<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
      return $this->belongsToMany(Role::class);
  }

    /**
* @param string|array $roles
*/
    public function authorizeRoles($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || 
          abort(401, 'This action is unauthorized.');
      }
      return $this->hasRole($roles) || 
      abort(401, 'This action is unauthorized.');
    }
    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
      return null !== $this->roles()->where('name', $role)->first();
    }
}
//hasRole: phương thức này để check nếu như người dùng có 1 quyền nào đó, tham số nhận vào string
//hasAnyRole: check nếu người dùng có một trong các quyền, tham số nhận vào array
//authorizeRoles: check nếu người dùng không thoả mãn quyền thì bắn ra exception, dùng cách này sau này ta sẽ render ra trang thông báo lỗi cho người dùng, tham số nhận vào array hoặc string
