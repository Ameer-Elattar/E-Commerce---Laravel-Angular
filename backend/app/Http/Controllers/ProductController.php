<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;


class ProductController extends Controller
{
     
    public function index() {
        $products = Product::where('stock', '>', 0)->get();
        return response()->json($products, 200);
    }
    
   
    public function store(StoreProductRequest $request) {
        $product = Product::create($request->validated());

        return response()->json($product, 201);
    }

    
    public function show($id) {
        $product = Product::where('id', $id)->where('stock', '>', 0)->first();
    
        if (!$product) {
            return response()->json(['error' => 'Product not found or unavailable'], 404);
        }
    
        return response()->json($product, 200);
    }
    


    public function showByName($title) {
        $product = Product::where('title', $title)->where('stock', '>', 0)->first();
    
        if (!$product) {
            return response()->json(['error' => 'Product not found or unavailable'], 404);
        }
    
        return response()->json($product, 200);
    }
    
    
   
    public function update(UpdateProductRequest $request, $id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->update($request->validated());

        return response()->json($product, 200);
    }

   
    public function destroy($id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}
