<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UserGeneratorService
{
    public function createFromFio(string $fio): User
    {
        $login = $this->makeLogin($fio);
        $password = Str::random(10);



        return User::create([
            'fullname' => $fio,
            'login' => $login,
            'password' => bcrypt($password),
            'group_id' => 1,
        ]);
    }

    private function makeLogin(string $fio): string
    {
        $parts = explode(' ', $fio);

        if (count($parts) < 3) {
            return Str::slug($fio) . rand(100, 999);
        }

        [$last, $first, $middle] = $parts;

        return Str::lower(
            Str::slug($first[0] . $middle[0] . $last)
        );
    }
}
