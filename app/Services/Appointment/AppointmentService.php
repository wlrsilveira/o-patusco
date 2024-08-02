<?php

namespace App\Services\Appointment;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AppointmentService
{
    public function create(array $data): Appointment
    {
        $appointment = Appointment::create($data);
        return $appointment;
    }

    public function update(Appointment $appointment, array $data): Appointment
    {
        $appointment->update($data);
        return $appointment;
    }

    public function delete(Appointment $appointment): void
    {
        $appointment->delete();
    }

    public function search(array $filters): Collection
    {
        $appointment = Appointment::query()
            ->when(isset($filters['start_date']), function ($query) use ($filters) {
                $query->where('date', '>=', $filters['start_date']);
            })
            ->when(isset($filters['end_date']), function ($query) use ($filters) {
                $query->where('date', '<=', $filters['end_date']);
            })
            ->when(isset($filters['animal_type_id']), function ($query) use ($filters) {
                $query->where('animal_type_id', $filters['animal_type_id']);
            })
            ->get();

        return $appointment;
    }

    public function attach(Appointment $appointment, User $user): Appointment
    {
        $appointment->doctor_id = $user->id;
        $appointment->save();
        return $appointment;
    }
}
