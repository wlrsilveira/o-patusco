<?php

namespace App\Services\Doctor;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorService
{
    public function create(array $data): User
    {
        $user = User::create($data);
        $user->assignRole('doctor');
        return $user;
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function list(array $array): LengthAwarePaginator
    {
        $perPage = $array['perPage'] ?? 15;
        $sortBy = $array['sortBy'][0]['key'] ?? 'id';
        $sortOrder = $array['sortBy'][0]['order'] ?? 'asc';

        return User::role('doctor')
            ->when(isset($array['search']), function ($query) use ($array) {
                $query->where('name', 'like', '%' . $array['search'] . '%')
                    ->orWhere('email', 'like', '%' . $array['search'] . '%');
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage);
    }
}
