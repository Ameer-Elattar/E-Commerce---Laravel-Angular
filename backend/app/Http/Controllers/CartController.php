<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\DeleteCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }
    public function index()
    {
        $currntUser = auth()->user();
       $userCartItems= Cart::where('user_id' , $currntUser->id)->get();
       return  CartResource::collection($userCartItems);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {   
        $currntUser = auth()->user();
        $validatedData=$request->validated();
        $validatedData['user_id']=$currntUser->id;

        if (Cart::where([
            'product_id' => $validatedData['product_id'],
            'user_id' => $currntUser->id,
          ])->exists()) {
            return response()->json(['error' => 'This product is already in your cart'],403 );
          } 

        $cart = Cart::create($validatedData);
        return response()->json(new CartResource( $cart), 201);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)

    {
        $this->authorize('update',$cart);
         $stockValidation= $this->checkStock($request,$cart->product_id);
        if(!$stockValidation){
            return response()->json(['error' => 'The stock is Lowar than  cart quantity'],403 );
            }
        $cart->update($request->validated());
        return response()->json(new CartResource( $cart), 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Cart $cart,DeleteCartRequest $request)
    // {
    //     // prevent a user from deleting items belonging to other users using request body
    //     $requestUserId=$request['user_id'];
    //     if ($cart->user_id !== $requestUserId) {
    //         return response()->json(['error' => 'You are not authorized to delete this cart.'], 403);
    //     }
        
    //      $cart->delete();
    //      return response()->json(['message' =>'Done'], 204);
    // }
    public function destroy(Cart $cart)
    {
        $this->authorize('delete',$cart);
         $cart->delete();
         return response()->json(['message' =>'Done'], 204);
    }

    public function destroyAllCartItems(int $id)
    {
      $user= User::findOrFail($id);
      $this->authorize('destroyAllCartItems',$user);
        $deleted = Cart::where('user_id', $id)->delete();
        if ($deleted) {
            return response()->json(['message' => 'All cart items deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'No cart items found for this user'], 404);
        }   
    }
 
public function getAllCartItems(int $id)
    {
        $user= User::findOrFail($id);
       $this->authorize('FindAllUserCartItems',$user) ;
        $cartItems = Cart::where('user_id', $id)->get();
        return response()->json($cartItems, 200);
    }
  
    private function checkStock($request,$product_id){
    $stock =Product::find($product_id)->stock;
    if($stock < $request['quantity']){
        return false;
    } 
     return  true;
   }
}
