<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();

        $adminRoles = Roles::where('name','admin')->first();
        $userRoles = Roles::where('name','user')->first();

        $admin = Admin::create([
			'admin_name' => 'dat',
			'admin_email' => 'dat@gmail.com',
			'admin_phone' => '0975175507',
			'admin_password' => md5('123')
        ]);

        $user = Admin::create([
			'admin_name' => 'hoang',
			'admin_email' => 'hoang@gmail.com',
			'admin_phone' => '0932023993',
			'admin_password' => md5('123')
        ]);

        $admin->roles()->attach($adminRoles);
        $user->roles()->attach($userRoles);
    }
}
