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
        $tasks = \DB::table('tasks')->select('*')->get();
        return view('welcome', array('tasks' => $tasks));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param object $request
     * @return Response
     */
    public function store($request)
    {
        \DB::insert("insert into tasks set name = '{$request->name}', priority = '{$request->priority}', dueIn = '{$request->dueIn}'");
        return 'created';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  object task
     * @return Response
     */
    public function update($task)
    {
        \DB::update("update tasks set priority = '{$task->getPriority()}', dueIn = '{$task->getDueIn()}' where id = '{$task->id}'");
        return \DB::table('tasks')->select('*')->get();
    }

    public function tickTasks(){
        $tasks = \DB::table('tasks')->select('*')->get();
        foreach ($tasks as $task) {
            $taskFighter = new \App\TaskFighter($task->name, $task->priority, $task->dueIn);
            $taskFighter->tick();
            \DB::update("update tasks set priority = '{$taskFighter->getPriority()}', dueIn = '{$taskFighter->getDueIn()}' where id = '{$task->id}'");
        }
        return \DB::table('tasks')->select('*')->get();

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        \DB::delete("delete from tasks where id = {$id}");
        return 'deleted';
    }
}
