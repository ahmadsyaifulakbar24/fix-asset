<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::orderBy('id', 'desc')->paginate('10');

        return view('pages.department.department', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = new Department();
        return view('pages.department.form_department', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department' => ['required', 'string', 'unique:departments,department'],
        ]);

        $input = $request->all();
        Department::create($input);

        return redirect()->route('department')->with('success', 'Department Has Been Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view("pages.department.form_department", compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department' => ['required', 'string', 'unique:departments,department,'.$department->id],
        ]);

        $input = $request->all();
        $department->update($input);
        return redirect()->route('department')->with('success', 'Department Has Been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('department')->with('success', 'Department Has Been Deleted Successfully');
    }
}
