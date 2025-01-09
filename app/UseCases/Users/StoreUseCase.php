<?php

namespace App\UseCases\Users;

use App\Models\User;
use App\UseCases\Core\UseCase;
use Illuminate\Support\Facades\Hash;

class StoreUseCase extends UseCase
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected string $phone,
        protected string $password
    ) {
    }

    public function action(): User
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        return $user;
    }
}
