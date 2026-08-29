<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();

        return $this->successResponse($categories, 'List of categories');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

           $category = Category::create($request->validated());

            return response()->json([
                'message' => 'New Category Added!',
                'category' => $category
            ]);
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
            $category = Category::find($id);

            if(!$category){
                return $this->errorResponse(404, 'Category not found!');
            }

            return $this->successResponse($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
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
