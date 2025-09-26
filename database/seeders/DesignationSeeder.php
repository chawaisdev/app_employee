<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            ['name' => 'Manager'],
            ['name' => 'Team Lead'],
            ['name' => 'Software Engineer'],
            ['name' => 'QA Engineer'],
            ['name' => 'HR'],
            ['name' => 'Intern'],
            ['name' => 'Designer'],
            ['name' => 'Accountant'],
            ['name' => 'Marketing'],
            ['name' => 'Support Staff'],
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
