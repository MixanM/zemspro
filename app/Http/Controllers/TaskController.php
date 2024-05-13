<?php

namespace App\Http\Controllers;

use App\Http\Resources\Task\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //

    function status($project_id)
    {
        $tasks = Task::where('project_id', $project_id)
            ->where('is_deleted','=', 0)
            ->where('status','<>', 2)
            ->get();
        //если задач нет , тогда ставим готово, иначе - 1 (на исполнении)
        if (count($tasks) === 0 )

        {
            Project::find($project_id)->update(['status' => 2]);
        }
        else { Project::find($project_id)->update(['status' => 1]);}
    }

    public function index()
    {
        $tasks = Task::query()
            ->leftJoin('users as users_author', function ($join) {
                $join->on('tasks.author', '=', 'users_author.id');
            })
            ->leftJoin('users as users_performer', function ($join) {
                $join->on('tasks.performer', '=', 'users_performer.id');
            })
            ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
            ->leftJoin('statuses', 'tasks.status', '=', 'statuses.id')
            ->select('tasks.*', 'users_author.name as author', 'users_performer.name as performer', 'statuses.title as status_title', 'projects.title as project_title', 'projects.id as project_id')
            ->where('tasks.is_deleted', 0)
            ->get();
        $tasks = TaskResource::collection($tasks)->resolve();
        return inertia('Task/Index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::query()
            ->select('title', 'id')
            ->where('is_deleted', 0)
            ->get();
        return inertia('Task/Create', compact('projects'));
    }

    public function store(Request $request)
    {

        // Проверка на наличие ошибок валидации
        $validatedData = $request->validate([
            'title' => 'required|string',
        ]);

        // Получаем id текущего пользователя
        $userId = auth()->user()->id;

        // Получаем id проекта
        $projectId = $request->project_id;
        // Получаем статус проекта
        $projectStatus = Project::find($projectId)->status;

        // Проверяем, что статус проекта не равен 1 (если это необходимо)
        if ($projectStatus !== 1) {
            // Обновляем статус проекта на 1
            Project::find($projectId)->update(['status' => 1]);
        }

        // Создание
        Task::create([
            'title' => $validatedData['title'],
            'overview' => $request['overview'],
            'author' => $userId,
            'project_id'=>$request['project_id'],
        ]);

        return redirect()->route('project.show' , $request['project_id']);
    }

    public function update(Task $task, Request $request)
    {

        //обновение данных задачи
        if (($request['par']) === 2)
        {
            $task->title = $request['title'];
            $task->overview = $request['overview'];

            //проверяем статус проекта, вдруг сменился id проекта, и нам нужно сменить в предыдущем
            $projectId = $task->project_id;
            $task->project_id = $request['project_id'];
        }

         //нажали старт задачи
        if (($request['par']) == 1)
        {
            $task->start = now();
            $task->status = 1;
            $task->performer =  auth()->user()->id;
        }

        //нажали закончить задачи
        if (($request['par']) == 0)
        {
            $task->stop = now();
            $task->status = 2;

            $task->difference =  $task->stop->diffInSeconds($task->start);
            //dd($task);
        }

        //удаление задачи
        if ($request['par'] == 3)
        {
            $task->is_deleted = 1;
        }

        $task->save();

        //// Проверяем, что у проекта нет задач со статусом <> 1 и is_deleted не равно 0
        if (($request['par']) !== 2)
        {
            $projectId = $request->project_id;
        }
        else
        {
            $this->status($request->project_id);
        }

        $this->status($projectId);


        return redirect()->route('project.show' , $request['project_id']);
    }

    public function show(Task $task)
    {
        $items = Task::query()
            ->leftJoin('users as users_author', function ($join) {
                $join->on('tasks.author', '=', 'users_author.id');
            })
            ->leftJoin('users as users_performer', function ($join) {
                $join->on('tasks.performer', '=', 'users_performer.id');
            })
            ->leftJoin('statuses', 'tasks.status', '=', 'statuses.id')
            ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
            ->select( 'users_author.name as author', 'users_performer.name as performer', 'statuses.title as status_title', 'projects.title as project_title', 'projects.id as project_id')
            ->where('tasks.id', '=', $task->id)
            ->get();

        //dd($items[0]['status_title']);
        $task->status_id = $task->status;
        $task->status = $items[0]['status_title'];
        $task->author = $items[0]['author'];
        $task->performer = $items[0]['performer'];


        return inertia('Task/Show', compact('task' ,'items'));
    }

    public function edit (Task $task)
    {

        $projects = Project::query()
            ->select('title', 'id')
            ->where('is_deleted', 0)
            ->get();

        $users = User::query()
            ->select('name', 'id')
            ->get();

        return inertia('Task/Edit', compact('task', 'projects', 'users'));
    }



}
