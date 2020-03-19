<?php

namespace App\Http\Resources;

use App\Repositories\Cache\SellerRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $flag = ($request->has('id') ? true : false);
        return [
            'id' => $this->id,
            'seller' => $this->when($flag, (new \App\Repositories\Cache\SellerRepository)->find($this->seller_id,['title','description'])),
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'time' => $this->created_at,
            'status' => ($this->status == 1 ? 'موجود' : 'در حال بررسی'),
        ];

    }
}
