<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
    
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            "updated_at" =>  $this->updated_at ,
            'status' => $this->status,
            'user_id' => $this->user->id,
            'user_full_name' => $this->user->full_name,
            'products' => ProductForOrderResource::collection($this->products),
            'total_price' => $this->products->sum('pivot.total')

        ];
    }
}
