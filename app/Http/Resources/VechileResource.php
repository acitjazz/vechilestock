<?php

namespace App\Http\Resources;


class VechileResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

   public function toArray($request)
   {
      return [
         'id' => $this->id,
         'model_id' => $this->model_id,
         'type' => $this->type,
         'price' => $this->price,
         'color' => $this->color,
         'created_at'=> $this->created_at->format('d/m/Y H:i:s'),
         'updated_at'=> $this->updated_at->format('d/m/Y H:i:s'),
      ];
   }
}
