<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Role Customer
        $role_customer = Role::where('name', 'customer')->first();
        if (empty($role_customer)) {

            $role_customer = new Role();
            $role_customer->name = 'customer';
            $role_customer->description = 'A Customer User';
            $role_customer->save();
        }

        // Role Admin
        $role_admin = Role::where('name', 'admin')->first();
        if (empty($role_admin)) {

            $role_admin = new Role();
            $role_admin->name = 'admin';
            $role_admin->description = 'A Admin User';
            $role_admin->save();
        }
    }
}
