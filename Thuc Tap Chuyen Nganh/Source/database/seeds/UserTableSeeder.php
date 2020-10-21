<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $role_employee = Role::where('name', 'employee')->first();
       $role_manager  = Role::where('name', 'admin')->first();
       $role_saler = Role::where('name', 'saler')->first();

       $employee = new User();
       $employee->name = 'Employee';
       $employee->email = 'employee@gmail.com';
       $employee->password = Hash::make('12345678');
       $employee->save();
       $employee->roles()->attach($role_employee);

       $saler = new User();
       $saler->name = 'Saler';
       $saler->email = 'saler@gmail.com';
       $saler->password = Hash::make('12345678');
       $saler->save();
       $saler->roles()->attach($role_saler);

       $manager = new User();
       $manager->name = 'Admin';
       $manager->email = 'admin@gmail.com';
       $manager->password = Hash::make('12345678');
       $manager->save();
       $manager->roles()->attach($role_manager);
    }
}

//Giải thích: Laravel hỗ trợ chúng ta đến tận chân răng 😃. Để thêm một quyền cho 1 user ta sử dụng hàm attach. Còn nếu muốn xóa đi 1 quyền nào đó thì các bạn sử dụng hàm detach($role_id) nhé, phần này quan trọng nên các bạn chú ý 2 hàm này để tự áp dụng tùy hoàn cảnh nhé
