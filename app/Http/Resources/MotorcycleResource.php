<?php

namespace App\Http\Resources;


class MotorcycleResource extends BaseResource
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
         'variants' => VechileListResource::collection($this->vechiles),
         'suspension' => $this->suspension,
         'transmission' => $this->transmission,
         'created_at'=> $this->created_at->format('d/m/Y H:i:s'),
         'updated_at'=> $this->updated_at->format('d/m/Y H:i:s'),
      ] : [];
   }
}
