<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $tasks = Task::all();
            return response()->json($tasks);
        }
        return view('calendar');
    }

    public function store(Request $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return response()->json(['success' => true]);
    }
}
