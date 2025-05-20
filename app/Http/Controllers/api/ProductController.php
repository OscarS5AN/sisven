<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json(['products' => $products]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:80'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
                'statusCode' => 400
            ], 400);
        }

        $product = Product::create($request->all());
        return response()->json(['product' => $product->load('category')], 201);
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:80'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
                'statusCode' => 400
            ], 400);
        }

        $product->update($request->all());
        return response()->json(['product' => $product->load('category')]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['products' => Product::with('category')->get(), 'success' => true]);
    }
}