@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 mx-auto">
            <form action="" method="POST" id="todo-add-from" class="form task-form mt-3 mb-5 d-flex">
                @csrf
                <div class="flex-fill mr-2">
                    <input type="text" id="task" name="task" placeholder="Enter task" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">+</button>
            </form>
            <div class="task-container uncheck-tasks mb-5 card">
                <h3 class="h5 card-header">Task List <span id="uncheck-list-count" class="float-right text-white badge bg-danger rounded-pill">{{ $uncheck_tasks_count }}</span></h3>
                <ul class="task-list card-body">
                    @foreach ($uncheck_tasks as $task)
                    <li class="task-item d-flex" data-id="{{ $task->id }}">

                        <input type="checkbox" name="checked" id="check" value="{{ $task->checked }}" class="d-inline-block my-auto mr-2">

                        <span class="flex-fill my-auto">{{ $task->title }}</span>

                        <button id="delete" class="btn delete-btn d-inline-block my-auto">&times</button>

                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="task-container check-tasks mb-5 card">
                <h3 class="h5 card-header">Task List (Done) <span id="check-list-count" class="float-right text-white badge bg-primary rounded-pill">{{ $check_tasks_count }}</span></h3>
                <ul class="task-list card-body">
                    @foreach ($check_tasks as $task)
                    <li class="task-item d-flex checked" data-id="{{ $task->id }}">

                        <input type="checkbox" name="checked" id="check" value="{{ $task->checked }}" class="d-inline-block my-auto mr-2" checked>

                        <span class="flex-fill my-auto">{{ $task->title }}</span>

                        <button id="delete" class="btn delete-btn d-inline-block my-auto">&times</button>

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endsection