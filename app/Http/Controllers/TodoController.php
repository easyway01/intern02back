<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    // ✅ 显示日历页面
    public function index()
    {
        return view('calendar'); // 页面视图
        return Todo::where('user_id', auth()->id())->get();

    }

    // ✅ 获取所有任务（FullCalendar 用）
    public function getTodos()
    {
        // FullCalendar 需要字段 id, title, start, end, allDay
        return response()->json(
            Todo::select('id', 'title', 'due_date as start', 'end_date as end')
                ->get()
                ->map(function ($todo) {
                    return [
                        'id' => $todo->id,
                        'title' => $todo->title,
                        'start' => $todo->start,
                        'end' => $todo->end,
                        'allDay' => true,
                    ];
                })
        );
    }

    // ✅ 添加任务
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'due_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $todo = Todo::create([
            'title' => $request->title,
            'due_date' => $request->due_date,
            'end_date' => $request->end_date,
            'duration_type' => $request->duration_type ?? 'day',
        ]);

        return response()->json([
            'id' => $todo->id,
            'title' => $todo->title,
            'due_date' => $todo->due_date,
            'end_date' => $todo->end_date,
        ]);
    }

    // ✅ 更新任务名称
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string'
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update(['title' => $request->title]);

        return response()->json(['message' => '任务已更新']);
    }

    // ✅ 删除任务
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return response()->json(['message' => '任务已删除']);
    }
}
