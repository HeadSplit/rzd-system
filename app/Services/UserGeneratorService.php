<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UserGeneratorService
{
    public function createFromFio(string $fio, int $groupId): array
    {
        $login = $this->generateUniqueLogin($fio);
        $password = Str::random(10);

        $user = User::create([
            'fullname' => $fio,
            'login' => $login,
            'password' => bcrypt($password),
            'group_id' => $groupId,
        ]);

        return [
            'user' => $user,
            'password' => $password
        ];
    }

    private function generateUniqueLogin(string $fio): string
    {
        $parts = explode(' ', $fio);

        if (count($parts) >= 3) {
            [$last, $first, $middle] = $parts;
            $base = Str::lower(Str::slug($first[0] . $middle[0] . $last));
        } else {
            $base = Str::lower(Str::slug($fio));
        }

        $login = $base;
        $i = 1;

        while (User::where('login', $login)->exists()) {
            $login = $base . $i;
            $i++;
        }

        return $login;
    }
}

