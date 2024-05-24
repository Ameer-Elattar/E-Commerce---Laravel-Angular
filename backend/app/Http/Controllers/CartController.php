<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\DeleteCartRequest;
use App\Http\Resources\CartResource;
 
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  CartResource::collection(Cart::all());
    }

     

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
       $stockValidation= $this->checkStock($request);
        if(!$stockValidation){
            return response()->json(['error' => 'The stock is Lowar than  cart quantity'],403 );
      }
         $cart = Cart::create($request->validated());
         return response()->json(new CartResource( $cart), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
         return new CartResource( $cart);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
         $stockValidation= $this->checkStock($request);
        if(!$stockValidation){
            return response()->json(['error' => 'The stock is Lowar than  cart quantity'],403 );
  
            }
        $cart->update($request->validated());
        return response()->json(new CartResource( $cart), 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart,DeleteCartRequest $request)
    {
        // prevent a user from deleting items belonging to other users using request body
        $requestUserId=$request['user_id'];
        if ($cart->user_id !== $requestUserId) {
            return response()->json(['error' => 'You are not authorized to delete this cart.'], 403);
        }
        
         $cart->delete();
         return response()->json(['message' =>'Done'], 204);
    }
    public function destroyAllCartItems(int $id)
    {
        
       User::findOrFail($id);
        $deleted = Cart::where('user_id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'All cart items deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'No cart items found for this user'], 404);
        }
    }

// Function to get all cart items for a user. 
// This could be done in a user resource, but I've provided a route for it anyway.
public function getAllCartItems(int $id)
    {
         
         User::findOrFail($id);
        $cartItems = Cart::where('user_id', $id)->get();

        return response()->json($cartItems, 200);
    }
  
    private function checkStock($request){
    $stock =Product::find($request['product_id'])->stock;
    if($stock < $request['quantity']){
        return false;
    } 
     return  true;
   }
}
