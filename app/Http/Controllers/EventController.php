<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Event::all();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = [
            "description" => $request->description,
            "date" => $request->date,
            "booking" => $request->booking,
            "zone_id" => $request->zone_id
        ];

        $newEvent = Event::create($data);

        $newEvent->save();

        return response()->json(['message' => 'Guardado con exito con id -> '.$newEvent->id], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $data = Event::find($event->id);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $data = Event::find($event->id);

        // DB::table('model_has_roles')->where('model_id',$id)->delete();

        //  $data->assignRole($request->input('roles'));
        $data->fill($request->all());

        $data->save();

        return response()->json(['message' => 'Actualizado con exito'],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $user = Event::find($event->id); // comprueba que existe

        Event::destroy($user->id);

        return response()->json(['message' => 'Borrado con exito'],200);

    }
}
