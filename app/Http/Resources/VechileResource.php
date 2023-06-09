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
         'vechile' => $this->type == 'Car'?
                      CarResource::make($this->car)->only('machine','passenger','type') :
                      MotorcycleResource::make($this->motorcycle)->only('machine','suspension','transmission'),
         'type' => $this->type,
         'price' => $this->price,
         'year' => $this->year,
         'color' => $this->color,
         'qty' => $this->qty,
         'created_at'=> $this->created_at->format('d/m/Y H:i:s'),
         'updated_at'=> $this->updated_at->format('d/m/Y H:i:s'),
      ];
   }
}
