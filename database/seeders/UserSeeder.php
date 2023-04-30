<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = User::create([
            'code' => '1',
            'name' => 'Super Admin',
            'phone_number' => null,
            'email' => 'superadmin@admin.com',
            'department_id' => 1,
            'location_id' => 1,
            'address' => null,
            'status' => 1,
            'role' => 'super-admin',
            'password' => Hash::make('12345678'),
        ]);

        $employee = User::create([
            'code' => '700',
            'name' => 'Employee',
            'phone_number' => null,
            'email' => 'employee@gmail.com',
            'department_id' => 1,
            'location_id' => 1,
            'address' => null,
            'status' => 1,
            'role' => 'employee',
            'password' => Hash::make('12345678'),
        ]);

        $manager = User::create([
            'code' => '600',
            'name' => 'Manager',
            'phone_number' => null,
            'email' => 'manager@gmail.com',
            'department_id' => 1,
            'location_id' => 1,
            'address' => null,
            'status' => 1,
            'role' => 'manager',
            'password' => Hash::make('12345678'),
        ]);

        $finance = User::create([
            'code' => '500',
            'name' => 'Finance',
            'phone_number' => null,
            'email' => 'finance@gmail.com',
            'department_id' => 1,
            'location_id' => 1,
            'address' => null,
            'status' => 1,
            'role' => 'finance',
            'password' => Hash::make('12345678'),
        ]);

        $it = User::create([
            'code' => '400',
            'name' => 'IT',
            'phone_number' => null,
            'email' => 'it@gmail.com',
            'department_id' => 1,
            'location_id' => 1,
            'address' => null,
            'status' => 1,
            'role' => 'it',
            'password' => Hash::make('12345678'),
        ]);

        $ga = User::create([
            'code' => '300',
            'name' => 'GA',
            'phone_number' => null,
            'email' => 'ga@gmail.com',
            'department_id' => 1,
            'location_id' => 1,
            'address' => null,
            'status' => 1,
            'role' => 'ga',
            'password' => Hash::make('12345678'),
        ]);
        
        $hrga = User::create([
            'code' => '200',
            'name' => 'HRGA',
            'phone_number' => null,
            'email' => 'hrga@gmail.com',
            'department_id' => 1,
            'location_id' => 1,
            'address' => null,
            'status' => 1,
            'role' => 'hrga',
            'password' => Hash::make('12345678'),
        ]);

        $presdir = User::create([
            'code' => '100',
            'name' => 'Presdir',
            'phone_number' => null,
            'email' => 'presdir@gmail.com',
            'department_id' => 1,
            'location_id' => 1,
            'address' => null,
            'status' => 1,
            'role' => 'presdir',
            'password' => Hash::make('12345678'),
        ]);
    }
}
