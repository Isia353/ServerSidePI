<?php

namespace App\Http\Controllers;

use App\Http\ApiResponse;
use App\Http\Requests\TaskValidator;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index','show']]);
        $this->middleware('permission:task-create', ['only' => ['store']]);
        $this->middleware('permission:task-edit', ['only' => ['update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data = Task::all();


        if ($data->isEmpty()) {
            return ApiResponse::error("No Task Could be indexed",404);
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskValidator $request)
    {

        $data = [
            "description" => $request->description,
            "title" => $request->title,
            "level" => $request->level,
            "finished" => $request->finished
        ];

        $newTask = Task::create($data);

        if(!$newTask){
            return ApiResponse::error("Coundt save the request!",509);
        }

        $newTask->save();

        return ApiResponse::success("All good ! with id ".$newTask->id, 200);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with('users')->find($id);
        if (!$task){
            return ApiResponse::error("No task with ".$id ." id here , sorry",404);
        }

        return ApiResponse::success('Success message', 200, [$task]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskValidator $request, string $id)
    {
        $data = Task::find($id);

        $currentValues = $data->getAttributes();

        if (!$data){
            return ApiResponse::error("Coundt Get the task to update!",509);
        }

        $data->fill([
            "description" => $request->description ?? $currentValues["description"],
            "title" => $request->title ?? $currentValues["title"],
            "level" => $request->level ?? $currentValues["level"],
            "finished" => $request->finished ?? $currentValues["finished"]
        ]);

        $data->save();

        return ApiResponse::success("All upddated with no issue !",200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            ApiResponse::error("Cant delete a Task that i cant find",404);
        }

        Task::destroy($id);

        return ApiResponse::success("Task no longer in our database!" ,200);

    }
}
