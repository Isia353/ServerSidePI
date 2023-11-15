<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Task::all();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = [
            "description" => $request->description,
            "title" => $request->title,
            "level" => $request->level,
            "finished" => $request->finished
        ];

        $newTask = Task::create($data);

        $newTask->save();

        return response()->json(['message' => 'Guardado con exito con id -> '.$newTask->id], 200);


    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task = Task::with('users')->find($task->id);


        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {

        $data = Task::find($task->id);

        $data->fill($request->all());

        $data->save();

        return response()->json(['message' => 'Actualizado con exito'],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task = Task::find($task->id);

        Task::destroy($task->id);

        return response()->json(['message' => 'Borrado con exito'],200);

    }
}
