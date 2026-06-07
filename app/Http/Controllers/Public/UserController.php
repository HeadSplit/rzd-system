<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function passport(Request $request): View
    {
        $userid = Auth::user()->id;

        $tickets = Ticket::where('user_id', $userid)->get();
        $documents = Document::where('user_id', $userid)->get();

        return view('user.passport', compact('tickets'));
    }
}
