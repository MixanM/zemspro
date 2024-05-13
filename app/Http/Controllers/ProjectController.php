<?php

namespace App\Http\Controllers;

use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use App\Models\Task;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->where('projects.is_deleted', 0)
            ->leftJoin('users', function ($join) {
                $join->on('projects.user_id', '=', 'users.id');
            })
            ->leftJoin('statuses', function ($join) {
                $join->on('projects.status', '=', 'statuses.id');
            })
            ->leftJoin('tasks', function ($join) {
                $join->on('projects.id', '=', 'tasks.project_id')
                    ->where('tasks.is_deleted', 0);
            })
            ->select('projects.*', 'users.name as user_name', 'statuses.title as status_title')
            ->selectRaw('COUNT(tasks.id) as total_tasks')
            ->selectRaw('(SELECT COUNT(*) FROM tasks WHERE tasks.project_id = projects.id AND tasks.status = 2 AND tasks.is_deleted = 0) as tasks_status_2')
            ->selectRaw('SUM(TIME_TO_SEC(tasks.difference)) as total_time')
            ->groupBy('projects.id')
            ->get();

        $projects = ProjectResource::collection($projects)->resolve();
        return inertia('Project/Index', compact('projects'));
    }

    public function show(Project $project)
    {

        $tasks = Task::query()
            ->where('tasks.is_deleted', false)
            ->leftJoin('users as user_author', function ($join) {
            $join->on('tasks.author', '=', 'user_author.id');
        })->leftJoin('statuses as task_status', function ($join) {
            $join->on('tasks.status', '=', 'task_status.id');
        })->leftJoin('users as user_performer', function ($join) {
            $join->on('tasks.performer', '=', 'user_performer.id');
        })->select('tasks.*', 'user_author.name as user_author', 'task_status.title as status_title', 'user_performer.name as user_performer')
            ->where('tasks.project_id', $project->id)
            ->get();

        return inertia('Project/Show', compact('project', 'tasks'));
    }

    public function create()
    {
        return inertia('Project/Create');
    }

    public function store (Request $request)
    {
        // Проверка на наличие ошибок валидации
        $validatedData = $request->validate([
            'title' => 'required|string',
            'overview' => 'required|string',
        ]);

        // Получаем id текущего пользователя
        $userId = auth()->user()->id;

        // Создание
        Project::create([
            'title' => $validatedData['title'],
            'overview' => $request['overview'],
            'user_id' => $userId,
        ]);

        return redirect()->route('project.index');

    }

    public function edit(Project $project)
    {
        return inertia('Project/Edit', compact('project'));
    }

    public function update(Project $project, Request $request)
    {

        // Обновляем данные проекта
        $project->title = $request->title;
        $project->overview = $request->overview;

        // Сохраняем изменения
        $project->save();
        return redirect()->route('project.index');

    }

    public function destroy(Project $project, Request $request)
    {

        $project->is_deleted = 1;
        $project->save();

        return redirect()->route('project.index');
    }
}
