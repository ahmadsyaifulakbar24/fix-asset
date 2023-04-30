<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('pages.category.category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category();
        return view('pages.category.form_category', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:categories,code'],
            'category' => ['required', 'string'],
        ]);

        $input = $request->all();
        Category::create($input);

        return redirect()->route('category')->with('success', 'Category Has Been Created Successfully');
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
    public function edit(Category $category)
    {
        return view("pages.category.form_category", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:categories,code,'.$category->id],
            'category' => ['required', 'string'],
        ]);

        $input = $request->all();
        $category->update($input);

        return redirect()->route('category')->with('success', 'Category Has Been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category')->with('success', 'Category Has Been Deleted Successfully');
    }
}
