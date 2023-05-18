<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CarDetailResource extends BaseResource
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
         'machine' => $this->machine,
         'passenger' => $this->passenger,
         'type' => $this->type,
         'variants' => VechileListResource::collection($this->vechiles),
         'created_at'=> $this->created_at->format('d/m/Y H:i:s'),
         'updated_at'=> $this->updated_at->format('d/m/Y H:i:s'),
      ];
   }
}
