<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $Order = Order::create($request->all());
            foreach ($request->all()['products'] as $products) {
            
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
        $Order = Order::find($id);
        if(!$Order){
            return response()->json(['message'=> 'Order not found'],404);
        }elseif($Order->status == 'done' || $Order->status == 'cancel'){
            return response()->json(['message'=> 'Cant Cancel order'],404);
        }
        $Order ->update(['status' => 'cancel']);


        foreach ($Order->products as $product) {
            $product->stock = $product->stock += $product->pivot->quantity;
            $product->save();
            }


        return response()->json($Order,202);
    }
}
