<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uncheck_tasks = Task::where('checked', false)->where('user_id', auth()->user()->id)->get();
        $check_tasks = Task::where('checked', true)->where('user_id', auth()->user()->id)->get();

        return view('home', [
            'uncheck_tasks' => $uncheck_tasks,
            'check_tasks' => $check_tasks,
            'uncheck_tasks_count' => count($uncheck_tasks),
            'check_tasks_count' => count($check_tasks),
        ]);
    }
}
