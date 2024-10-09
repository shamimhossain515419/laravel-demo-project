<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use http\Env\Request;

class CategoryController extends HelperController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        // Respond with a success message
        return $this->sendResponse($category, 'category Create successfully.');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // Validate and retrieve the validated data
        $validated = $request->validated();

        try {
            // Create the category
            $category = Category::create($validated);

            // Respond with a structured success message
            return $this->sendResponse($category, 'Category created successfully.', 201);
        } catch (\Exception $e) {
            // If any error occurs, respond with an error message
            return $this->sendError('Category creation failed.', $e->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Eager load posts that belong to the category
        $category = Category::with('posts')->find($category->id);

        // Check if the category exists
        if (!$category) {
            return $this->sendError('Category not found.', 404);
        }

        // Respond with category and related posts
        return $this->sendResponse($category, 'Category retrieved successfully along with related posts.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
