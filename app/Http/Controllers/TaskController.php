<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function mytask()
    {
       $task = Task::where('user_id', auth()->user()->id)->first();

        return view('pages.task', compact('task'));
    }
}
