<?php

namespace App\Services\Appointment;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function search(array $filters): LengthAwarePaginator
    {
        $perPage = $array['perPage'] ?? 15;
        $sortBy = $array['sortBy'][0]['key'] ?? 'id';
        $sortOrder = $array['sortBy'][0]['order'] ?? 'asc';

        $appointment = Appointment::query()
            ->when(isset($filters['date']), function ($query) use ($filters) {
                $query->where('date', $filters['date']);
            })
            ->when(isset($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(isset($filters['email']), function ($query) use ($filters) {
                $query->where('email', 'like', '%' . $filters['email'] . '%');
            })
            ->when(isset($filters['animal_name']), function ($query) use ($filters) {
                $query->where('animal_name', 'like', '%' . $filters['animal_name'] . '%');
            })
            ->when(isset($filters['animal_type_id']), function ($query) use ($filters) {
                $query->where('animal_type_id', $filters['animal_type_id']);
            })
            ->when(isset($filters['doctor_id']), function ($query) use ($filters) {
                $query->where('doctor_id', $filters['doctor_id']);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage);

        return $appointment;
    }

    public function attach(Appointment $appointment, User $user): Appointment
    {
        $appointment->doctor_id = $user->id;
        $appointment->save();
        return $appointment;
    }
}
