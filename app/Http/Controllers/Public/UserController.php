<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Passanger;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function passport(Request $request, $routeId, $wagonId): View
    {
        $userid = Auth::user()->id;

        $tickets = Ticket::where('user_id', $userid)->get();
        $documents = Document::where('user_id', $userid)->get();

        session([
            'booking.route_id' => $routeId,
            'booking.wagon_id' => $wagonId,
            'booking.selected_seats' => $request->selected_seats,
        ]);

        return view('user.passport', compact('tickets'));
    }

    public function create(): View
    {
        $passenger = new Passanger();
        $existingPassengers = Passanger::where('user_id', auth()->id())->get();

        return view('user.passenger-form', compact('passenger', 'existingPassengers'));
    }

    public function edit($id): View
    {
        $passenger = Passanger::where('user_id', auth()->id())->findOrFail($id);
        $existingPassengers = Passanger::where('user_id', auth()->id())
            ->where('id', '!=', $id)
            ->get();

        return view('user.passenger-form', compact('passenger', 'existingPassengers'));
    }

    public function store(Request $request)
    {
        if ($request->has('existing_document_id') && $request->existing_document_id) {
            $existingPassenger = Passanger::where('user_id', auth()->id())
                ->findOrFail($request->existing_document_id);

            $passenger = new Passanger();
            $passenger->user_id = auth()->id();
            $passenger->surname = $existingPassenger->surname;
            $passenger->name = $existingPassenger->name;
            $passenger->patronymic = $existingPassenger->patronymic;
            $passenger->has_patronymic = $existingPassenger->has_patronymic;
            $passenger->gender = $existingPassenger->gender;
            $passenger->birth_date = $existingPassenger->birth_date;
            $passenger->is_medical = $existingPassenger->is_medical;
            $passenger->document = $existingPassenger->document;
            $passenger->series = $existingPassenger->series;
            $passenger->number = $existingPassenger->number;
            $passenger->save();

            return redirect()->route('pages.passport')->with('success', 'Пассажир добавлен из существующего документа');
        }

        $validated = $request->validate([
            'surname' => 'required|string',
            'name' => 'required|string',
            'patronymic' => 'nullable|string',
            'has_patronymic' => 'boolean',
            'gender' => 'required|in:male,female',
            'birth_date' => 'nullable|date',
            'is_medical' => 'boolean',
            'document' => 'required|string',
            'series' => 'required|string',
            'number' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_medical'] = $request->has('is_medical');
        $validated['has_patronymic'] = $request->has('has_patronymic');

        if ($request->has('birth_date') && $request->birth_date) {
            $validated['birth_date'] = date('Y-m-d', strtotime($request->birth_date));
        }

        $passenger = Passanger::create($validated);

        return redirect()->route('pages.passport')->with('success', 'Пассажир добавлен');
    }

    public function update(Request $request, $id)
    {
        $passenger = Passanger::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'surname' => 'required|string',
            'name' => 'required|string',
            'patronymic' => 'nullable|string',
            'has_patronymic' => 'boolean',
            'gender' => 'required|in:male,female',
            'birth_date' => 'nullable|date',
            'is_medical' => 'boolean',
            'document' => 'required|string',
            'series' => 'required|string',
            'number' => 'required|string',
        ]);

        $validated['is_medical'] = $request->has('is_medical');
        $validated['has_patronymic'] = $request->has('has_patronymic');

        if ($request->has('birth_date') && $request->birth_date) {
            $validated['birth_date'] = date('Y-m-d', strtotime($request->birth_date));
        }


        $passenger->update($validated);

        return redirect()->back()->with('success', 'Пассажир обновлён');
    }

    public function show($id)
    {
        $passenger = Passanger::where('user_id', auth()->id())->findOrFail($id);

        return response()->json([
            'id' => $id,
            'surname' => $passenger->surname,
            'name' => $passenger->name,
            'patronymic' => $passenger->patronymic,
            'has_patronymic' => (bool)$passenger->has_patronymic,
            'gender' => $passenger->gender,
            'birth_date' => $passenger->birth_date ? $passenger->birth_date->format('Y-m-d') : null,
            'is_medical' => (bool)$passenger->is_medical,
            'document' => $passenger->document,
            'series' => $passenger->series,
            'number' => $passenger->number,
        ]);
    }

    public function personal(): View
    {
        $passangers = Passanger::where('user_id', auth()->id())->get();
        $tickets = Ticket::where('user_id', auth()->id())->get();

        return view('user.personal', compact('passangers', 'tickets'));
    }


}
