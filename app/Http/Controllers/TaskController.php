<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index()
    {
        return view('welcome', array('tasks' => Task::all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(){}

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $task = new Task;
        $task->fill([
            'name' => $request->name,
            'priority' => $request->priority,
            'dueIn' => $request->dueIn]);
        $task->save();
        return Task::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Task::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){}

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return Task[]|\Illuminate\Database\Eloquent\Collection
     */
    public function update(Request $request, $id)
    {
        $update = Task::find($id);
        $update->name = $request->name;
        $update->priority = $request->priority;
        $update->dueIn = $request->dueIn;
        $update->save();
        return Task::all();
    }

    public function tickTasks(){
        $tasks = Task::all();
        foreach ($tasks as $task) {
            $taskFighter = new \App\TaskFighter($task->name, $task->priority, $task->dueIn);
            $taskFighter->tick();

            //update task
            $update = Task::find($task->id);
            $update->name = $taskFighter->getName();
            $update->priority = $taskFighter->getPriority();
            $update->dueIn = $taskFighter->getDueIn();
            $update->save();
        }

        return Task::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return Task::all();
    }
}
