<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Passanger;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{

    public function index(): View
    {
        return view('admin.index');
    }

    public function tickets(): View
    {
        $tickets = Ticket::all();

        return view('admin.tickets', compact('tickets'));
    }

    public function users(): View
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    public function passangers(): View
    {
        $passangers = Passanger::all();

        return view('admin.passangers', compact('passangers'));
    }

    public function analytics(): View
    {
        return view('admin.analytics');
    }
}
