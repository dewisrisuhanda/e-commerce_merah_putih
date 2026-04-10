<?php

namespace App\Repositories\Admin;

use App\Models\User;

class UserRepository
{
    public function getAll(): array
    {
        return User::latest()
            ->get()
            ->map(fn (User $user) => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'address'    => $user->address,
                'role'       => $user->role,
                'created_at' => $user->created_at->format('d M Y'),
            ])
            ->toArray();
    }
}
