<?php

namespace App\Http\Resources;


class MotorcycleDetailResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

   public function toArray($request)
   {
      return  $this->resource ? [
         'id' => $this->id,
         'machine' => $this->machine,
         'suspension' => $this->suspension,
         'transmission' => $this->transmission,
         'variants' => VechileListResource::collection($this->vechiles),
         'created_at'=> $this->created_at->format('d/m/Y H:i:s'),
         'updated_at'=> $this->updated_at->format('d/m/Y H:i:s'),
      ] : [];
   }
}
