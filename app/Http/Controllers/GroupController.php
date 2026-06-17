<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::withCount('users')->latest()->get();

        return view('admin.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function groups()
    {
        $groups = Group::withCount('users')->latest()->get();

        return view('admin.groups.index', compact('groups'));
    }

    public function showGroup($id)
    {
        $group = Group::with('users')->findOrFail($id);

        return view('admin.groups.show', compact('group'));
    }

    public function deleteGroup($id)
    {
        $group = Group::findOrFail($id);

        $group->users()->delete();
        $group->delete();

        return redirect()->route('admin.groups')->with('success', 'Группа удалена');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Пользователь удалён');
    }
}
