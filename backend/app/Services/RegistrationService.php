<?php

namespace App\Services;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class RegistrationService
{
    /**
     *
     * @param \App\Models\User $user
     * @return array
     */
    public function store(RegistrationRequest $request) 
    {
        return User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
