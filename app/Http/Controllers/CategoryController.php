<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryModel;
    function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'))->with('title', 'Categories | View List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create')->with('title', 'Categories | Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $category = $this->categoryModel->storeCategory($validated);

        if (!$category) {
            emotify('error', 'Failed to add category');
            return redirect()->route('categories.index');
        }

        emotify('success', 'Category added successfully');
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category])->with('title', 'Categories | Update Details');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $updatedCategory = $this->categoryModel->updateCategory($validated, $category->id);

        if (!$updatedCategory) {
            emotify('error', 'Failed to update category');
            return redirect()->route('categories.index');
        }

        emotify('success', 'Category updated successfully');
        return redirect()->route('categories.index');
    }
}
