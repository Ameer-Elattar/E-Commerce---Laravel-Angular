<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    
     
    public function index() {
        $products = Product::where('stock', '>', 0)->get();
        return response()->json($products, 200);
    }
    

   
    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move("images/products",$imageName);
        }
    
        $product = Product::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $imageName,
            'stock' => $request->input('stock')
        ]);
    
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
    
    

   
    public function update(UpdateProductRequest $request, $id)
    {
      
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $this->authorize('update',$product);
        
        $imageName = $product->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $this->deleteImage($product->image);

            $image->move("images/products",$imageName);
        
        }
    
    
        $productData = [
            'title' => $request->input('title', $product->title),
            'description' => $request->input('description', $product->description),
            'price' => $request->input('price', $product->price),
            'image' => $imageName,
            'stock' => $request->input('stock', $product->stock)
        ];
    
        $product->update($productData);
    
        return response()->json(['message'=>'product updated','data'=>$product], 200);
    }


    

    public function destroy($id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $this->authorize('delete',$product);

        $this->deleteImage($product->image);
        $product->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }


    private function deleteImage($imageName) {
        if ($imageName) {
            $imagePath = public_path("images/products/{$imageName}");
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
    }

}
