<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return OrderResource::collection(Order::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::guard('api')->id());
        if ($user->cart ->count() == 0) {
            return response()->json(['error' => "cart is empty"], 404);
        }
        DB::beginTransaction();
        try {
            $Order = Order::create(['user_id' => $user->id]);
            foreach ($user->cart as $products) {
            
                $Product = Product::findOrFail($products['product_id']);

                if($products['quantity'] > $Product->stock){
                    throw new \Exception("quantity less than available");
                }

                OrderProduct::create([
                    'quantity'=> $products['quantity'],
                    'product_id'=> $Product->id,
                    'price'=> $Product->price,
                    'order_id'=> $Order->id,
                ]);

                $Product->stock = $Product->stock -= $products['quantity'];
                $Product->save();
                }
                $user->cart()->delete();

                DB::commit();
                return response()->json($Order,200);

        } catch (\Exception $e) {
            
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 404);

        }
  
           
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Order = Order::find($id);
        if(!$Order){
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json(new OrderResource($Order),200);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Order = Order::find($id);
        if(!$Order){
            return response()->json(['message'=> 'Order not found'],404);
        }
        $Order ->update($request->all());
        return response()->json($Order,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Order = Order::find($id);
        if(!$Order){
            return response()->json(['message'=> 'Order not found'],404);
        }
        $Order->delete();
        return response()->json(['message'=> 'Order deleted'],200);
    }

    public function cancel(string $id)
    {
        try{
                
            $Order = Order::findOrFail($id);
        
            if($Order->status != 'progress'){
                throw new \Exception("Cant Cancel order");
            }

            DB::beginTransaction();

            $Order ->update(['status' => 'cancel']);


            foreach ($Order->products as $product) {
                $product->stock = $product->stock += $product->pivot->quantity;
                $product->save();
            }
            
            DB::commit();
            return response()->json($Order,202);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
    
        }
    }


    public function done(Request $request, string $id)
    {
        $Order = Order::find($id);
        if(!$Order || $Order->status != 'progress'){
            return response()->json(['message'=> 'Order Cant Be Done'],404);
        }

        $Order ->update(['status'=> 'done']);
        return response()->json($Order,200);
    }

}
