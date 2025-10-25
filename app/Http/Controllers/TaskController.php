<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function index(Request $request): View
    {
        $status = $request->query('status');

        $query = Task::query();

        if ($status === Task::STATUS_ACTIVE) {
            $query->where('is_completed', false);
        } elseif ($status === Task::STATUS_COMPLETED) {
            $query->where('is_completed', true);
        }

        $tasks = $query->latest()->get();

        return view('tasks.index', compact('tasks', 'status'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus(Task $task): RedirectResponse
    {
        $task->is_completed = !$task->is_completed;
        $task->save();

        return back()->with('success', 'Task status updated.');
    }
}
