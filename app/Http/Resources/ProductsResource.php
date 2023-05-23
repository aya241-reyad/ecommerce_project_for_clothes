<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->subCategory->name,

            'original_price' => $this->price,
            'selling_price' => $this->price_after_tax,
            'image' => $this->attachmentRelation[0]->path,

            'colors' => $this->productColors->map(function ($item, $key) {
                return [
                    'id' => $item->color->id ?? null,
                    'color' => $item->color->code ?? null,
                ];
            }),

            'sizes' => $this->productSizes->map(function ($item, $key) {
                return [
                    'id' => $item->size->id ?? null,
                    'size' => $item->size->size ?? null,
                ];
            }),

            'reviews' => $this->reviews->map(function ($item, $key) {
                return [
                    'name' => $item->client->user_name,
                    'review' => $item->review,
                    'rate' => $item->rate,
                    'created_at' => Carbon::parse($item->created_at)->format('Y-m-d'),

                ];
            }),
        ];
    }
}
