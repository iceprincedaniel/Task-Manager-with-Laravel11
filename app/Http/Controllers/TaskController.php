<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $projectId = $request->query('project_id');

        $tasks = Task::when($projectId, function ($query) use ($projectId) {
                $query->where('project_id', $projectId);
            })
            ->orderBy('priority')
            ->get();

        return view('tasks.index', compact('tasks', 'projects', 'projectId'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $data['priority'] =
            Task::where('project_id', $data['project_id'])->max('priority') + 1;

        Task::create($data);

        return back();
    }


    public function update(Request $request, Task $task)
    {
        $request->validate(['name'=>'required']);
        $task->update(['name'=>$request->name]);
        return back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
        ]);

        foreach ($request->order as $index => $taskId) {
            Task::where('id', $taskId)->update([
                'priority' => $index + 1
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

}

