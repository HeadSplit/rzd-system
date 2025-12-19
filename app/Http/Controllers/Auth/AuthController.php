<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if(Auth::attempt(['login' => $request->login, 'password' => $request->login])) {
            Session::regenerate();
            return redirect()->route('');
        }
        return back()->withErrors(['auth' => 'Неверный логин или пароль'])->withInput();
    }
}
