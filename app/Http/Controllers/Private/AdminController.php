<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Passanger;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{

    public function index(): View
    {
        return view('admin.index');
    }

    public function users(): View
    {
        $users = User::all();
        $files = Storage::files('pdfs');

        return view('admin.createUsers', compact('users', 'files'));
    }

    public function createUsers(): View
    {
        $files = Storage::files('pdfs');

        return view('admin.createUsers', compact('files'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx'],
        ]);

        $file = $request->file('file');

        $filename = $file->getClientOriginalName();

        $path = $file->storeAs('xlsx/import', $filename);

        Artisan::call('scan:xlsx');

        return back()->with('success', 'Файл загружен и отправлен в обработку');
    }

    public function showPdf()
    {
        $files = Storage::files('pdfs');

        return view('admin.users.import', compact('files'));
    }

    public function viewPdf($file)
    {
        $path = storage_path('app/pdfs/' . $file);

        return response()->file($path);
    }

    public function downloadPdf($file)
    {
        $path = storage_path('app/pdfs/' . $file);

        return response()->download($path);
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

    public function loginForm(): View
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

       if(Auth::attempt(['login' => $data['login'], 'password' => $data['password']])) {
           $request->session()->regenerate();
           return redirect()->route('admin.index');
       }
        return back()->withErrors(['Неверный логин или пароль']);
    }

    public function deleteFile($file)
    {
        $path = 'pdfs/' . $file;

        if (Storage::exists($path)) {
            Storage::delete($path);


            return back()->with('success', 'Файл удалён');
        }

        return back()->with('error', 'Файл не найден');
    }

    public function tickets()
    {
        $tickets = Ticket::with(['user', 'passanger'])->latest()->get();

        return view('admin.tickets', compact('tickets'));
    }

    public function showTicket($id)
    {
        $ticket = Ticket::with(['user', 'passanger'])->findOrFail($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function deleteTicket($id)
    {
        Ticket::findOrFail($id)->delete();

        return redirect()->route('admin.tickets')->with('success', 'Билет удалён');
    }

    public function results(Request $request)
    {
        $groupId = $request->get('group_id');

        $users = User::with(['task', 'group'])
            ->when($groupId, fn($q) => $q->where('group_id', $groupId))
            ->get();

        $groups = \App\Models\Group::all();

        return view('admin.results', compact('users', 'groups', 'groupId'));
    }


}
