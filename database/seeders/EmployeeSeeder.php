<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'full_name'       => 'Sheikh Sahab',
                'email'           => 'sheikhsahab2911@gmail.com',
                'phone'           => '03216641951',
                'user_type'       => 'employee',
            ],
            [
                'full_name'       => 'Dawood Ahmad',
                'email'           => 'dawoodahmad3565@gmail.com',
                'phone'           => '03047751658',
                'user_type'       => 'employee',
            ],
            [
                'full_name'       => 'Mubashir Raza',
                'email'           => 'mubashirraza315030@gmail.com',
                'phone'           => '03286859849',
                'user_type'       => 'employee',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create([
                'full_name'       => $employee['full_name'],
                'email'           => $employee['email'],
                'phone'           => $employee['phone'],
                'user_type'       => $employee['user_type'],
                'designation_id'  => 1,
                'password'        => Hash::make('employee@123'),
            ]);
        }
    }
}
