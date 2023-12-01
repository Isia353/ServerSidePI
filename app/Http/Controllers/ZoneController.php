<?php

namespace App\Http\Controllers;

use App\Http\ApiResponse;
use App\Http\Requests\ZoneValidator;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:zone-list|zone-create|zone-edit|zone-delete', ['only' => ['index','show']]);
        $this->middleware('permission:zone-create', ['only' => ['store']]);
        $this->middleware('permission:zone-edit', ['only' => ['update']]);
        $this->middleware('permission:zone-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data = Zone::all();

        if ($data->isEmpty()) {
            return ApiResponse::error("No Event Could be indexed",404);
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ZoneValidator $request)
    {
        $data = [
            "description" => $request->description,
            "type" => $request->type,
            "user_id" => $request->user_id,
        ];

        $newZone = Zone::create($data);

        if(!$newZone){
            return ApiResponse::error("Coundt save the request!",509);
        }

        $newZone->save();

        return ApiResponse::success("All good ! with id ".$newZone->id, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Zone::with('animals')->find($id);

        if (!$data){
            return ApiResponse::error("No zone with ".$id ." id here , sorry",404);
        }

        return ApiResponse::success('Success message', 200, [$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ZoneValidator $request, Zone $zone)
    {
        $data = Zone::find($zone->id);

        $currentValues = $data->getAttributes();

        if (!$data){
            return ApiResponse::error("Coundt Get the zone to update!",509);
        }

        $data->fill([
            "description" => $request->description ?? $currentValues["description"],
            "type" => $request->type ?? $currentValues["type"],
            "user_id" => $request->user_id ?? $currentValues["user_id"]
        ]);
        $data->save();

        return ApiResponse::success("All upddate with no issue !",200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Zone::find($id);

        Zone::destroy($id);

        return ApiResponse::success("Zone no longer in our database!" ,200);
    }
}
