<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'subCategory' => $this->SubCat->map(function ($item, $key) {
                return [
                    'id' => $item->id,
                    'category_id' => $item->category->id,
                    'title' => $item->name,
                    'description' => $item->description,
                    'image' => $item->attachmentRelation[0]->path ?? null,
                   

                ];

            }),

        ];
    }
}