<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:80', 'unique:categories'],
            'description' => ['nullable', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
                'statusCode' => 400
            ], 400);
        }

        $category = Category::create($request->all());
        return response()->json(['category' => $category], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json(['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:80', 'unique:categories,name,'.$id],
            'description' => ['nullable', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
                'statusCode' => 400
            ], 400);
        }

        $category->update($request->all());
        return response()->json(['category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['categories' => Category::all(), 'success' => true]);
    }
}