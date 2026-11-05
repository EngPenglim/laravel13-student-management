<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic user and department
        $this->seed();
    }

    /**
     * Test 1: User can see login and register pages.
     */
    public function test_auth_pages_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login Form');

        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register Form');
    }

    /**
     * Test 2: User can register a new account.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'New Student Officer',
            'email' => 'officer@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/students');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'officer@example.com']);
    }

    /**
     * Test 3: User can login with seeded credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'adminwoman@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/students');
        $this->assertAuthenticated();
    }

    /**
     * Test 4: Relationship between Student and Department works.
     */
    public function test_student_and_department_relationship(): void
    {
        $dept = Department::where('dept_name', 'Management Information System')->first();
        $this->assertNotNull($dept);

        $student = $dept->students()->first();
        $this->assertNotNull($student);
        $this->assertEquals($dept->dept_id, $student->department->dept_id);
    }

    /**
     * Test 5: CRUD - Create new student.
     */
    public function test_can_create_new_student(): void
    {
        $user = User::first();
        $dept = Department::first();

        $response = $this->actingAs($user)->post('/students', [
            'student_name' => 'Chan Dara',
            'email' => 'chandara@example.com',
            'gender' => 'Male',
            'enrollment_date' => '2023-09-01',
            'enrollment' => '1.5 years',
            'department_id' => $dept->dept_id,
            'description' => 'Top student',
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'student_name' => 'Chan Dara',
            'email' => 'chandara@example.com',
            'department_id' => $dept->dept_id,
        ]);
    }

    /**
     * Test 6: Search by student name and department filter.
     */
    public function test_search_and_filter_students(): void
    {
        $user = User::first();

        // Search for 'Kong Sopheak'
        $response = $this->actingAs($user)->get('/students?search=Kong+Sopheak');
        $response->assertStatus(200);
        $response->assertSee('Kong Sopheak');
        $response->assertDontSee('Leng Makara');

        // Filter by gender Female
        $response = $this->actingAs($user)->get('/students?gender=Female');
        $response->assertStatus(200);
        $response->assertSee('Ly Chhailin');
        $response->assertSee('Pov Nita');
        $response->assertDontSee('Leng Makara');
    }

    /**
     * Test 7: CRUD - Update student.
     */
    public function test_can_update_student(): void
    {
        $user = User::first();
        $student = Student::first();
        $dept = Department::latest('dept_id')->first();

        $response = $this->actingAs($user)->put("/students/{$student->student_id}", [
            'student_name' => 'Updated Student Name',
            'email' => 'updated@example.com',
            'gender' => 'Female',
            'enrollment_date' => '2023-01-01',
            'department_id' => $dept->dept_id,
            'description' => 'Updated note',
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'student_id' => $student->student_id,
            'student_name' => 'Updated Student Name',
            'department_id' => $dept->dept_id,
        ]);
    }

    /**
     * Test 8: CRUD - Delete student.
     */
    public function test_can_delete_student(): void
    {
        $user = User::first();
        $student = Student::latest('student_id')->first();
        $id = $student->student_id;

        $response = $this->actingAs($user)->delete("/students/{$id}");
        $response->assertRedirect('/students');
        $this->assertDatabaseMissing('students', ['student_id' => $id]);
    }
}
