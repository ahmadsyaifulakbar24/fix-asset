<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = Location::orderBy('id', 'desc')->paginate(10);
        return view('pages.office.office', compact('offices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $office = new Location();
        $parents = Location::whereNull('parent_id')->get();
        return view('pages.office.form_office', compact('office', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:locations,code'],
            'location' => ['required', 'string'],
            'parent ' => ['nullable', 'exists:locations,id'],
        ]);

        $input = $request->except(['parent_id']);
        $input['parent_id'] = $request->parent;
        Location::create($input);

        return redirect()->route('office')->with('success', 'Office Has Been Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $office)
    {
        $parents = Location::whereNull('parent_id')->get();
        return view('pages.office.form_office', compact('office', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $office)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:locations,code,'.$office->id],
            'location' => ['required', 'string'],
            'parent ' => ['nullable', 'exists:locations,id'],
        ]);

        $input = $request->except(['parent_id']);
        $input['parent_id'] = $request->parent;
        $office->update($input);
        
        return redirect()->route('office')->with('success', 'Office Has Been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $office)
    {
        $office->delete();

        return redirect()->route('office')->with('success', 'Office Has Been Deleted Successfully');
    }
}
