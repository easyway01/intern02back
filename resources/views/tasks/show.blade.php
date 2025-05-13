@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Task Details</h2>
    <p><strong>Title:</strong> {{ $task->title }}</p>
    <p><strong>Status:</strong> {{ $task->completed ? 'Completed' : 'Incomplete' }}</p>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
