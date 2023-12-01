<?php

namespace App\Http\Controllers;

use App\Http\ApiResponse;
use App\Http\Requests\EventValidator;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    function __construct()
    {
        $this->middleware('permission:event-list|event-create|event-edit|event-delete', ['only' => ['index','show']]);
        $this->middleware('permission:event-create', ['only' => ['store']]);
        $this->middleware('permission:event-edit', ['only' => ['update']]);
        $this->middleware('permission:event-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data = Event::all();

        if ($data->isEmpty()) {
            return ApiResponse::error("No Event Could be indexed",404);
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventValidator $request)
    {
        $data = [
            "description" => $request->description,
            "date" => $request->date,
            "booking" => $request->booking,
            "zone_id" => $request->zone_id
        ];

        $newEvent = Event::create($data);

        if(!$newEvent){
            return ApiResponse::error("Coundt save the request!",509);
        }
        $newEvent->save();

        return ApiResponse::success("All good ! with id ".$newEvent->id, 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::find($id);

        if (!$event){
            return ApiResponse::error("No event with ".$id ." id here , sorry",404);
        }

        return ApiResponse::success('Success message', 200, [$event]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventValidator $request, string $id)
    {
        $data = Event::find($id);

        $currentValues = $data->getAttributes();

        if (!$data){
            return ApiResponse::error("Coundt Get the event to update!",509);
        }


        $data->fill([
            "description" => $request->description ?? $currentValues["description"],
            "date" => $request->date ?? $currentValues["date"],
            "booking" => $request->booking ?? $currentValues["booking"],
        ]);
        $data->zone_id = $currentValues["zone_id"];

        $data->save();
        return ApiResponse::success("All upddate with no issue !",200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            ApiResponse::error("Cant delete a event that i cant find",404);
        }
        Event::destroy($id);

        return ApiResponse::success("Event no longer in our database!" ,200);
    }
}
