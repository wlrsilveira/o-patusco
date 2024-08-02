<?php

namespace App\Services\Attendant;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AttendantService
{
    public function __construct()
    {
    }

    public function updatePassword(User $user, array $data = []): void
    {
        $user->password = Hash::make($data['password']);
        $user->save();
    }

    public function create(array $data): User
    {
        $user = User::create($data);
        $user->assignRole('attendant');
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


}
