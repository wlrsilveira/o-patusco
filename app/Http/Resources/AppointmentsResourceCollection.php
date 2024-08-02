<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentsResourceCollection extends JsonResource
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
            'client_name' => $this->name,
            'client_email' => $this->email,
            'animal_name' => $this->animal_name,
            'animal_type' => $this->animalType->description,
            'animal_age' => $this->animal_age,
            'symptoms' => $this->symptoms,
            'date' => $this->date,
            'period' => $this->period,
            'doctor' => new DoctorResource($this->doctor),
        ];
    }
}
