<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProducCatResource extends JsonResource
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
            'title' => $this->name,
            'description' => $this->description,
            'image' => $this->attachmentRelation[0]->path ?? null,
            'products' => $this->products->map(function ($item, $key) {

                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'category' => $item->subCategory->name,
                    'original_price' => $item->price,
                    'selling_price' => $item->price_after_tax,
                    'rate' => $item->reviews->avg('rate'),

                    'image' => $item->attachmentRelation[0]->path ?? null,

                    'colors' => $item->productColors->map(function ($item, $key) {
                        return [
                            'id' => $item->color->id ?? null,
                            'color' => $item->color->code ?? null,
                        ];
                    }),
                ];

            })->paginate(8),

        ];

    }
}
