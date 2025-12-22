<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\RouteStation;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Train;
use App\Models\Wagon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $date = $dateFrom
            ? Carbon::createFromFormat('d.m.Y', $dateFrom)->toDateString()
            : null;

        $routes = Route::query()
            ->when($from && $to, function ($q) use ($from, $to, $date) {

                $q->whereExists(function ($sub) use ($from, $to, $date) {

                    $sub->select(DB::raw(1))
                        ->from('route_stations as rs_from')
                        ->join('route_stations as rs_to', function ($join) use ($to) {
                            $join->on('rs_from.route_id', '=', 'rs_to.route_id')
                                ->where('rs_to.station_id', $to);
                        })
                        ->whereColumn('rs_from.route_id', 'routes.id')
                        ->where('rs_from.station_id', $from)
                        ->whereColumn('rs_from.order', '<', 'rs_to.order')
                        ->when($date, fn ($q) =>
                        $q->whereDate('rs_from.departure_time', $date)
                        );
                });
            })
            ->with(['stations' => fn ($q) => $q->orderBy('route_stations.order')])
            ->get();

        return view('pages.search', compact('routes', 'from', 'to', 'dateFrom'));
    }

    public function service(Route $route): View
    {
        $route->load('train.wagons.wagonprice');

        return view('pages.service', compact('route'));
    }

    public function seats(Route $route, Wagon $wagon): View
    {
        $seats = Seat::where('wagon_id', $wagon->id)->get();

        return view('pages.seats', compact('wagon', 'seats'));
    }

    public function passenger(Route $route, Wagon $wagon, array $seats): View
    {

    }

    public function show(): View
    {
        return view('pages.show');
    }
}
