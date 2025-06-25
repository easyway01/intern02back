<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // ✅ 1. 任务列表
    public function index()
    {
        $tasks = Task::all()->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'due_date' => optional($task->due_date)->format('Y-m-d'),
                'end_date' => optional($task->end_date)->format('Y-m-d'),
                'description' => $task->description,
                'status' => $task->status,
            ];
        });

        return response()->json($tasks);
    }

    // ✅ 2. 新增任务
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:due_date',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,done',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task = Task::create([
            'title' => $request->title,
            'due_date' => $request->due_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json($task, 201);
    }

    // ✅ 3. 更新任务
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:due_date',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,done',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task->update([
            'title' => $request->title,
            'due_date' => $request->due_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json($task);
    }

    // ✅ 4. 删除任务
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
    }

        // ✅ 5. 可选：显示单一任务
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }

        return response()->json([
            'id' => $task->id,
            'title' => $task->title,
            'due_date' => optional($task->due_date)->format('Y-m-d'),
            'end_date' => optional($task->end_date)->format('Y-m-d'),
            'description' => $task->description,
            'status' => $task->status,
        ]);
    }

    // ✅ 新增的视图显示方法
    public function taskListView()
    {
        return view('task-list');
    }
}
