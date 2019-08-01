<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $role_customer = Role::where('name', 'customer')->first();
        $role_admin    = Role::where('name', 'admin')->first();

        // Customer creation
        $customer = User::where('email', 'mary@example.com')->first();
        if (empty($customer)) {

            $customer           = new User();
            $customer->name     = 'Mary';
            $customer->email    = 'mary@example.com';
            $customer->password = bcrypt('marypass');
            $customer->save();
            $customer->roles()->attach($role_customer);
        }

        // Admin сreation
        $admin = User::where('email', 'sofi@example.com')->first();
        if (empty($admin)) {

            $admin           = new User();
            $admin->name     = 'Sofi';
            $admin->email    = 'sofi@example.com';
            $admin->password = bcrypt('sofipass');
            $admin->save();
            $admin->roles()->attach($role_admin);
        }
    }
}
