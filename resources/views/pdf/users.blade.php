<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ФИО</th>
        <th>Логин</th>
        <th>Пароль</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $userData)
        @if($userData['user'])
            <tr>
                <td>{{ $userData['user']->fullname }}</td>
                <td>{{ $userData['user']->login }}</td>
                <td>{{ $userData['password'] }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
</body>
</html>
