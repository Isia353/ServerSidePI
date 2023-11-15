<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Zone::all();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            "description" => $request->description,
            "type" => $request->title,
            "user_id" => $request->level,
        ];

        $newZone = Zone::create($data);

        $newZone->save();

        return response()->json(['message' => 'Guardado con exito con id -> '.$newZone->id], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        $data = Zone::with('animals')->find($zone->id);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $data = Zone::find($zone->id);

        $data->fill($request->all());

        $data->save();

        return response()->json(['message' => 'Actualizado con exito'],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        $task = Zone::find($zone->id);

        Zone::destroy($task->id);

        return response()->json(['message' => 'Borrado con exito'],200);

    }
}
