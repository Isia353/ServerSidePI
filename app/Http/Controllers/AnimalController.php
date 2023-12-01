<?php

namespace App\Http\Controllers;

use App\Exceptions\NoModelFound;
use App\Http\Requests\AnimalValidator;
use App\Http\ApiResponse;
use App\Models\Animal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:animal-list|animal-create|animal-edit|animal-delete', ['only' => ['index','show']]);
        $this->middleware('permission:animal-create', ['only' => ['store']]);
        $this->middleware('permission:animal-edit', ['only' => ['update']]);
        $this->middleware('permission:animal-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data = Animal::all();

        if ($data->isEmpty()) {
            return ApiResponse::error("No animal Could be indexed",404);
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnimalValidator $request)
    {
        $route = $this->createRoutePhoto($request);
        $data = [
            "description" => $request->description,
            "sex" => $request->sex,
            "name" => $request->name,
            "img" =>  $this->setStringToString($route),
            "conservation_state" => $this->setStringToString($request->conservation_state),
            "zone_id" => $request->zone_id
        ];

            $newAnimal = Animal::create($data);

            if(!$newAnimal){
                return ApiResponse::error("Coundt save the request!",509);
            }
        $newAnimal->save();

        return ApiResponse::success("All good !", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $animal = Animal::find($id);

        if (!$animal){
            return ApiResponse::error("No animal with ".$id ." id here , sorry",404);
        }

        return ApiResponse::success('Success message', 200,[$animal] );
    }

    /**
     * Update the specified resource in storage.
     */
    //cuidar subida de imagenes
    public function update(AnimalValidator $request,string $id)
    {

         $data = Animal::find($id);

         $currentValues = $data->getAttributes();

        if (!$data){
            return ApiResponse::error("Coundt Get the animal to update!",509);
        }
        if($request->hasFile("img")){
            $oldRoute = dirname($data->img);
            $fileName = $this->getFileName($request);
            $trimedFileName = $this->setStringToString($fileName);
            $newFile = $oldRoute."/".$trimedFileName;
        }



        $data->fill([
            "description" => $request->description ?? $currentValues["description"],
            "sex" => $request->sex ?? $currentValues["sex"],
            "name" => $request->name ?? $currentValues["name"],
        ]);
        $data->img = $newFile ?? $currentValues["img"] ;
        $data->conservation_state = $this->setStringToString($request->conservation_state) ?? $currentValues["conservation_state"] ;
        $data->zone_id = $currentValues["zone_id"];
        $data->save();

        return ApiResponse::success("All upddate with no issue !",200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $data = Animal::find($id);

        if (!$data) {
            ApiResponse::error("Cant delete an animal that i cant find",404);
        }

        Animal::destroy($id);

        self::DeleteRoutePhoto($data->img);


        return ApiResponse::success("Animal no longer in our database!" ,200);

    }
    ///////// separar //////////////////////////
    public function createRoutePhoto(Request $request)
    {

        $uuid = Uuid::uuid4()->toString();
        $shortUuid = substr($uuid, 0, 13);
        $folderPath = 'images/' . $shortUuid."/";

        if ($request->hasFile("img")) {

            $file = $request->file("img");
            $fileName = $file->getClientOriginalName();
            $file->storeAs($folderPath, $fileName, 'public');

            return $folderPath.$fileName;
        }
        return null;
    }

    public function DeleteRoutePhoto($route)
    {
        Storage::delete($route);

        Storage::deleteDirectory(dirname($route));
    }

    public function getFileName(Request $request){

        if ($request->hasFile($request["img"])) {

            $file = $request->file($request["img"]);

            $fileName = $file->getClientOriginalName();

            return $fileName;
        }
        return "No file sended";
    }

    public function setStringToString($string){

        return strtolower(str_replace(' ', '', trim($string)));
    }
}
