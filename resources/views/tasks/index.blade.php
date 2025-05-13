@extends('layouts.app')

@section('content')
<div class="container">
    <h2>To-Do List</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">+ Add Task</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-group">
        @foreach ($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span @if($task->completed) style="text-decoration: line-through;" @endif>
                    {{ $task->title }}
                </span>
                <div>
                    <!-- 完成/取消完成 -->
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-inline">
                        @csrf @method('PUT')
                        <input type="hidden" name="completed" value="{{ $task->completed ? 0 : 1 }}">
                        <button class="btn btn-sm btn-{{ $task->completed ? 'warning' : 'success' }}">
                            {{ $task->completed ? 'Undo' : 'Done' }}
                        </button>
                    </form>

                    <!-- 编辑 -->
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-secondary">Edit</a>

                    <!-- 删除 -->
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
