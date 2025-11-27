<?php

namespace App\Services;

use App\Models\Group;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserGeneratorService
{
    public function createFromFio(string $fio, int $groupId): ?array
    {
        if (User::where('fullname', $fio)->where('group_id', $groupId)->exists()) {
            Log::info("пользователь $fio уже есть в базе данных");
            return null;
        }

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
            $raw = $first[0] . $middle[0] . $last;
        } else {
            $raw = $fio;
        }

        $trans = Str::transliterate($raw);
        $base = Str::lower(Str::slug($trans));

        if ($base === '') {
            $base = 'user';
        }

        $login = $base;
        $i = 1;

        while (User::where('login', $login)->exists()) {
            $login = $base . $i;
            $i++;
        }

        return $login;
    }

    public function createGroup(string $groupName, string $fileName): Group
    {
        return Group::firstOrCreate(
            ['name' => $groupName],
            ['filename' => $fileName]
        );
    }

    public function generatePdf(array $users, string $filename = 'users.pdf'): string
    {
        $pdf = Pdf::loadView('pdf.users', ['users' => $users])
            ->setPaper('a4');

        $path = storage_path('app/pdfs/' . $filename);
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $pdf->save($path);

        return $path;
    }
}
