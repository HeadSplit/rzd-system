<?php

namespace App\Http\Controllers;

use App\Models\Passanger;
use Illuminate\Http\Request;

class PassangerController extends Controller
{
    public function passangers()
    {
        $passangers = Passanger::with('user')->latest()->get();

        return view('admin.passanger.index', compact('passangers'));
    }

    public function showPassanger($id)
    {
        $passanger = Passanger::with('user')->findOrFail($id);

        return view('admin.passanger.show', compact('passanger'));
    }

    public function deletePassanger($id)
    {
        Passanger::findOrFail($id)->delete();

        return back()->with('success', 'Пассажир удалён');
    }
}
