<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'passanger_id' => 'required|exists:passangers,id',
        ]);

        $booking = session('booking');

        if (!$booking) {
            return redirect()->route('home');
        }

        $route = Route::findOrFail($booking['route_id']);
        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'passanger_id' => $request->passanger_id,
            'from' => $booking['search']['from_station'],
            'to' => $booking['search']['to_station'],
            'from_date' => $booking['search']['date_from'],
            'to_date' => $booking['search']['date_to'],
            'adult_person' => (int) $booking['search']['adult_person'],
            'child_with_place' => (int) $booking['search']['child_with_place'],
            'child_without_place' => (int) $booking['search']['child_without_place'],
            'place_for_invalid' => (int) $booking['search']['place_for_invalid'],
            'place_for_family' => (int) $booking['search']['place_for_family'],
            'pets' => false,
            'car' => false,
            'motorcycle' => false,
        ]);

        $ticket->seats()->attach($booking['seat_ids']);

        Seat::whereIn('id', $booking['seat_ids'])
            ->update(['is_available' => false]);

       session()->forget('booking');

        return redirect()->route('home');
    }
}
