<?php

namespace App\Http\Resources;


class VechileListResource extends BaseResource
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
         'type' => $this->type,
         'price' => $this->price,
         'year' => $this->year,
         'color' => $this->color,
         'qty' => $this->qty,
      ];
   }
}
