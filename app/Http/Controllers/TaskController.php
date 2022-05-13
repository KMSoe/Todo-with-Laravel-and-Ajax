<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $uncheck_tasks = Task::where('checked', false)->where('user_id', auth()->user()->id)->get();
        $check_tasks = Task::where('checked', true)->where('user_id', auth()->user()->id)->get();

        return Response::json([
            'success' => true,
            'tasks' => Task::all(),
            'uncheck_tasks_count' => count($uncheck_tasks),
            'check_tasks_count' => count($check_tasks),
        ]);
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }
        $task = new Task();
        $task->title = $request->title;
        $task->user_id = auth()->user()->id;
        $task->save();

        return Response::json([
            'success' => true,
            'task' => $task,
            'task_count' => count(Task::where('checked', false)->where('user_id', auth()->user()->id)->get()),
        ]);
    }

    public function show(Task $task)
    {
        //
    }

    public function update(Request $request, Task $task)
    {
        $task = Task::find($request->id);
       

        if(Gate::allows('todo-delete', $task)){
            $task->checked = !$task->checked;
            $task->save();

            return Response::json([
                'success' => true,
                'uncheck_task_count' => count(Task::where('checked', false)->where('user_id', auth()->user()->id)->get()),
                'check_task_count' => count(Task::where('checked', true)->where('user_id', auth()->user()->id)->get()),
                'task' => $task,
            ]);
        } else{
            return Response::json([
                'success' => false,
            ]);
        }
    }

    public function destroy(Request $request, Task $task)
    {
        $task = Task::find($request->id);
        $checked = $task->checked;

        if(Gate::allows('todo-delete', $task)){
            $task->delete();

            return Response::json([
                'success' => true,
                'task_count' => count(Task::where('checked', $checked)->where('user_id', auth()->user()->id)->get()),
                'task' => $task,
            ]);
        } else{
            return Response::json([
                'success' => false,
            ]);
        }
    }
}
