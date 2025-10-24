<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Get all Products
    public function index()
    {
        // Code to retrieve and return all products
        $products = Product::all();
        return response()->json(['products' => $products], 200);
    }

    // Create a new Product
    public function store(Request $request)
    {
        $validate = Validator::make(($request->all()), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'hover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
    }
}
