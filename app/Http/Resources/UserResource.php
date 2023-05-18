<?php

namespace App\Http\Resources;


class UserResource extends BaseResource
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
         'name' => $this->name,
         'email' => $this->email,
      ];
   }
}
