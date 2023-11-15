<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Animal::all();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            "description" => $request->description,
            "sex" => $request->sex,
            "name" => $request->name,
            "img" =>  $this->createRoutePhoto($request),
            "conservation_state" => $request->conservation_state,
            "zone_id" => $request->zone_id
        ];

        $newAnimal = Animal::create($data);

        $newAnimal->save();

        return response()->json(['message' => 'Guardado con exito con id -> '.$newAnimal->id], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {

        $data = Animal::with('zone')->find($animal->id);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    //cuidar subida de imagenes
    public function update(Request $request, Animal $animal)
    {

        $data = Animal::find($animal->id);

        if ($request->img) {
            $newRoute = $this->createRoutePhoto($request);
        }

        //       UrlCreatorService::deleteStorage($data->img);
        $data->img = $newRoute;

        $data->fill($request->all());

        $data->save();

        return response()->json(['message' => 'Actualizado con exito'], 200);

    }

    /**
     * Remove the specified resource from storage.
     */ //al borrar tambien borrar en storage , no media que no se use
    public function destroy(Animal $animal)
    {

        $data = Animal::find($animal->id);

        if (!$data) {
            return response()->json(['message' => 'Dicho Elemento no existe'], 404);
        }
        //  $route = $data->img;

        Animal::destroy($animal->id);


        //   UrlCreatorService::deleteStorage($route);

        return response()->json(['message' => ' El elemento ha sido borrado con exito']);

    }

    public function createRoutePhoto(Request $request)
    {

        $uuid = Uuid::uuid4()->toString();
        $folderPath = 'images/' . $uuid;


        if ($request->hasFile("img")) {

            $file = $request->file("img");
            $fileName = $file->getClientOriginalName();
            $file->storeAs($folderPath, $fileName, 'public');

            return $folderPath;
        }
        return $folderPath;
    }
}
