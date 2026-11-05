<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments with student counts.
     */
    public function index()
    {
        $departments = Department::withCount('students')->orderBy('dept_id')->get();
        return view('departments.index', compact('departments'));
    }

    /**
     * Store a newly created department.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255'],
            'manager_id' => ['nullable', 'numeric'],
            'location_id' => ['nullable', 'numeric'],
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully!');
    }

    /**
     * Update the specified department.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255'],
            'manager_id' => ['nullable', 'numeric'],
            'location_id' => ['nullable', 'numeric'],
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified department.
     */
    public function destroy(Department $department)
    {
        $name = $department->dept_name;
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', "Department '{$name}' deleted successfully!");
    }
}
