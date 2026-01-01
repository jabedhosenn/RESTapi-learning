<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryCollection;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'data' => new CategoryCollection($categories),
        ]);
    }

    public function categoryWithProducts()
    {
        $categories = Category::with('products')->get();
        return response()->json([
            'message' => 'Categories with products retrieved successfully',
            'data' => new CategoryCollection($categories),
        ]);
    }
}
