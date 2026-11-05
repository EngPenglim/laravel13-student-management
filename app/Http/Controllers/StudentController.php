<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of students with search, filters, and statistics.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $departmentId = $request->input('department_id');
        $gender = $request->input('gender');
        $sort = $request->input('sort', 'newest');

        $query = Student::with('department');

        // Search by student name, email, or department name
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($dq) use ($search) {
                      $dq->where('dept_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Department
        if (!empty($departmentId) && $departmentId !== 'all') {
            $query->where('department_id', $departmentId);
        }

        // Filter by Gender
        if (!empty($gender) && $gender !== 'all') {
            $query->where('gender', $gender);
        }

        // Sorting
        switch ($sort) {
            case 'oldest':
                $query->orderBy('student_id', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('student_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('student_name', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('student_id', 'desc');
                break;
        }

        $students = $query->paginate(10)->withQueryString();

        // Calculate statistics
        $totalStudents = Student::count();
        $totalDepartments = Department::count();

        // Calculate average enrollment years
        $allStudents = Student::whereNotNull('enrollment_date')->get();
        if ($allStudents->count() > 0) {
            $totalYears = $allStudents->reduce(function ($carry, $student) {
                $years = Carbon::parse($student->enrollment_date)->diffInDays(now()) / 365.25;
                return $carry + $years;
            }, 0);
            $avgEnrollment = number_format($totalYears / $allStudents->count(), 1) . ' yrs';
        } else {
            $avgEnrollment = '0.0 yrs';
        }

        $departments = Department::orderBy('dept_name')->get();

        return view('students.index', compact(
            'students',
            'departments',
            'totalStudents',
            'totalDepartments',
            'avgEnrollment',
            'search',
            'departmentId',
            'gender',
            'sort'
        ));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $departments = Department::orderBy('dept_name')->get();
        return view('students.create', compact('departments'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'dob' => ['nullable', 'date'],
            'enrollment_date' => ['required', 'date'],
            'enrollment' => ['nullable', 'string', 'max:100'],
            'department_id' => ['required', 'exists:departments,dept_id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // If enrollment years is not manually specified, calculate precisely
        if (empty($validated['enrollment']) && !empty($validated['enrollment_date'])) {
            $days = Carbon::parse($validated['enrollment_date'])->diffInDays(now());
            $years = $days / 365.25;
            $validated['enrollment'] = $years . ' years';
        }

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student registered successfully!');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load('department');
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $departments = Department::orderBy('dept_name')->get();
        return view('students.edit', compact('student', 'departments'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'dob' => ['nullable', 'date'],
            'enrollment_date' => ['required', 'date'],
            'enrollment' => ['nullable', 'string', 'max:100'],
            'department_id' => ['required', 'exists:departments,dept_id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        if (empty($validated['enrollment']) && !empty($validated['enrollment_date'])) {
            $days = Carbon::parse($validated['enrollment_date'])->diffInDays(now());
            $years = $days / 365.25;
            $validated['enrollment'] = $years . ' years';
        }

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student details updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $studentName = $student->student_name;
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', "Student '{$studentName}' deleted successfully!");
    }
}
