<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;

class ExceptionResource extends AbstractResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        return [
            'message' => $this->resource['message'] ?? null,
            'code' =>$this->resource['code'] ?? null,
        ];
    }
}
