<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $stations = Station::all();

        return view('pages.index', compact('stations'));
    }

    public function search(Request $request): View
    {
        $from = $request->get('from_station');
        $to = $request->get('to_station');
        $dateFrom = $request->get('date_from');

        $date = $dateFrom ? Carbon::createFromFormat('d.m.Y', $dateFrom)->format('Y-m-d') : null;

        $routes = Route::query()
            ->when($from, fn($q) =>
            $q->whereHas('stations', fn($q) =>
            $q->where('route_stations.station_id', $from)
                ->when($date, fn($q) => $q->whereDate('route_stations.departure_time', $date))
            )
            )
            ->when($to, fn($q) =>
            $q->whereHas('stations', fn($q) =>
            $q->where('route_stations.station_id', $to)
            )
            )
            ->with(['stations' => fn($q) => $q->orderBy('pivot_order')])
            ->get();

        return view('pages.search', compact('routes', 'from', 'to', 'dateFrom'));

    }
}
