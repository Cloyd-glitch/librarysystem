<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Get all categories
         $categories = Category::withCount('books')->latest()->get();
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('admin.categories.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
            $validatedData = $request->validate([
                'name' => 'required|unique:categories,name|string|max:255',
                'isActive' => 'boolean',
            ]);

            // Auto-fill date_added
            $validatedData['date_added'] = now();

            Category::create($validatedData);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category created successfully.');
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
    public function edit(string $id)
    {
        //
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
        {
            $category = Category::findOrFail($id);

            // 1. Validate
            $validatedData = $request->validate([
                
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
                'isActive' => 'nullable', 
            ]);

            $validatedData['isActive'] = $request->has('isActive') ? 1 : 0;

            // 3. Update
            $category->update($validatedData);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category updated successfully.');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::findOrFail($id);

        //  Check if category has books before deleting
        if ($category->books()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with existing books.');
        }
        
         $category->delete();
         return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
