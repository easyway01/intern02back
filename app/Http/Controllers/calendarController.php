<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    // ✅ 显示 Calendar 页面
    public function index()
    {
        return view('calendar');
    }

    // ✅ 获取所有任务数据，供 FullCalendar 使用
    public function getEvents()
{
    $todos = \App\Models\Todo::all();

    return response()->json($todos->map(function ($todo) {
    return [
        'id' => $todo->id,
        'title' => $todo->title,
        'start' => \Carbon\Carbon::parse($todo->due_date)->toIso8601String(),
        'end' => $todo->end_date ? \Carbon\Carbon::parse($todo->end_date)->toIso8601String() : null,
        'description' => $todo->description,
        'status' => $todo->status,
        'due_date' => $todo->due_date->format('Y-m-d'), // 👈 明确加上
        'end_date' => $todo->end_date ? $todo->end_date->format('Y-m-d') : null, // 👈 加上
    ];
}));


}

    // ✅ 新增任务
public function store(Request $request)
{
    try {
        Log::info('📥 Incoming todo:', $request->all());

        $validated = $request->validate([
    'title' => 'required|string|max:255',
    'due_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:due_date',
    'description' => 'nullable|string',
]);


        $todo = Todo::create([
            'title' => $validated['title'],
            'due_date' => $validated['due_date'],
            'end_date' => $validated['end_date'],
            'description' => $validated['description'] ?? '',
            'status' => Todo::STATUS_IMPLEMENTING ?? 'implementing', // ✅ 如果常量不存在
        ]);

        return response()->json([
            'message' => 'Task created',
            'todo' => $todo
        ]);
    } catch (\Exception $e) {
Log::error('❌ Todo create error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json(['message' => 'Server error'], 500);
    }
}

    // ✅ 更新任务
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:due_date',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:' . Todo::STATUS_IMPLEMENTING . ',' . Todo::STATUS_DONE,
        ]);

        $todo->update([
            'title' => $validated['title'],
            'due_date' => $validated['due_date'],
            'end_date' => $validated['end_date'],
            'description' => $validated['description'] ?? '',
            'status' => $validated['status'] ?? $todo->status,
        ]);

        return response()->json(['message' => 'Updated successfully']);
    }

    // ✅ 删除任务
    public function destroy($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $todo->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // ✅ 标记为已完成
    public function markAsDone($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->status = Todo::STATUS_DONE;
        $todo->save();

        return response()->json(['message' => 'Marked as done']);
    }
}
