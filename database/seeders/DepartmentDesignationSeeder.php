<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Designation;

class DepartmentDesignationSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Human Resources' => ['HR Manager', 'Recruiter', 'HR Executive'],
            'Finance' => ['Finance Manager', 'Accountant', 'Auditor'],
            'IT' => ['Software Engineer', 'System Admin', 'Tech Lead'],
            'Sales' => ['Sales Manager', 'Sales Executive', 'Business Development'],
        ];

        foreach ($departments as $deptName => $designations) {
            $department = Department::create([
                'name' => $deptName,
                'code' => strtoupper(substr($deptName, 0, 3))
            ]);

            foreach ($designations as $designation) {
                Designation::create([
                    'department_id' => $department->id,
                    'title' => $designation
                ]);
            }
        }
    }
}
