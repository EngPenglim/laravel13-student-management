<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Default Admin User (as shown in PDF login/register example: adminwoman@gmail.com)
        User::updateOrCreate(
            ['email' => 'adminwoman@gmail.com'],
            [
                'name' => 'Admin Woman',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Seed Departments
        $mis = Department::updateOrCreate(
            ['dept_id' => 1],
            [
                'dept_name' => 'Management Information System',
                'manager_id' => 101,
                'location_id' => 1,
            ]
        );

        $design = Department::updateOrCreate(
            ['dept_id' => 2],
            [
                'dept_name' => 'Design',
                'manager_id' => 102,
                'location_id' => 2,
            ]
        );

        $cs = Department::updateOrCreate(
            ['dept_id' => 3],
            [
                'dept_name' => 'Computer Science',
                'manager_id' => 103,
                'location_id' => 3,
            ]
        );

        // 3. Seed Students (as shown in PDF page 7 & page 8)
        Student::updateOrCreate(
            ['student_id' => 1],
            [
                'student_name' => 'Kong Sopheak',
                'email' => 'kongsopheak@gmail.com',
                'gender' => 'Male',
                'dob' => '2002-05-15',
                'enrollment' => '3.905874077043 years',
                'enrollment_date' => '2022-01-01',
                'description' => null,
                'department_id' => $mis->dept_id,
            ]
        );

        Student::updateOrCreate(
            ['student_id' => 2],
            [
                'student_name' => 'Ly Chhailin',
                'email' => 'lin@gmail.com',
                'gender' => 'Female',
                'dob' => '2003-08-20',
                'enrollment' => '3.905874077043 years',
                'enrollment_date' => '2022-01-01',
                'description' => null,
                'department_id' => $design->dept_id,
            ]
        );

        Student::updateOrCreate(
            ['student_id' => 3],
            [
                'student_name' => 'Pov Nita',
                'email' => 'povnita@gmail.com',
                'gender' => 'Female',
                'dob' => '2003-12-10',
                'enrollment' => '2.6319014749248 years',
                'enrollment_date' => '2023-04-11',
                'description' => 'OK',
                'department_id' => $mis->dept_id,
            ]
        );

        Student::updateOrCreate(
            ['student_id' => 4],
            [
                'student_name' => 'Leng Makara',
                'email' => 'lengmakara@gmail.com',
                'gender' => 'Male',
                'dob' => '2004-03-25',
                'enrollment' => '1.0729973653153 years',
                'enrollment_date' => '2024-11-01',
                'description' => null,
                'department_id' => $design->dept_id,
            ]
        );
    }
}
