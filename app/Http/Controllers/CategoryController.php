<?php

namespace App\Http\Controllers;

use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Category extends Controller
{
    /**
     * Display a listing of the Category.
     */
    public function index()
    {
        $categories = ModelsCategory::all();
        return response()->json(['categories' => $categories], 200);
    }

    /**
     * Store a newly created Category in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => "Category creation failed",
                'errors' => $validate->errors(),
            ], 400);
        }
        $category = new ModelsCategory;
        $category->name = $request->name;
        $category->save();
        return response()->json([
            'message' => "Category created successfully",
            'category' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
