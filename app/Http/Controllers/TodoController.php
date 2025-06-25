<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function index()
    {
        return response()->json(Todo::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'due_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:due_date',
            'description' => 'nullable|string',
        ]);

        $todo = Todo::create([
            'title' => $validated['title'],
            'due_date' => $validated['due_date'],
            'end_date' => $validated['end_date'] ?? $validated['due_date'],
            'description' => $validated['description'] ?? '',
            'status' => Todo::STATUS_IMPLEMENTING,
        ]);

        return response()->json($todo);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
    'title' => 'sometimes|required|string',
    'due_date' => 'sometimes|date',
    'end_date' => 'sometimes|date|after_or_equal:due_date',
    'description' => 'nullable|string',
    'status' => 'sometimes|in:implementing,done', // ✅ 增加这一行
]);


            $todo = Todo::findOrFail($id);
            $todo->update($validated);

            return response()->json($todo);
        } catch (\Exception $e) {
            Log::error("Update failed for ID $id: " . $e->getMessage());
            return response()->json(['message' => 'Failed to update task'], 500);
        }
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $todo->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
