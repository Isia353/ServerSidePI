<?php

namespace App\Http\Controllers;

use App\Http\ApiResponse;
use App\Http\Requests\UserValidator;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

// Aqui se asignan o se quitan roles
class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();

        if ($data->isEmpty()) {
            return ApiResponse::error("No User Could be indexed",404);
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserValidator $request)
    {

        $userD = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            "type" => $request->type
        ];
        $user = User::create($userD);

        if(!$user){
            return ApiResponse::error("Coundt save the request!",509);
        }

        // user array no objeto
        if ($request->has('roles')) {
            $roles = Role::whereIn('name', $request->roles)->get();
            $user->roles()->attach($roles);
        } else {
            $defaultRole = Role::where('name', 'visitor')->first();
            $user->roles()->attach($defaultRole);
        }


        $user->save();

        return ApiResponse::success("All good ! with id ".$user->id, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('zone')->find($id);

        if (!$user){
            return ApiResponse::error("No user with ".$id ." id here , sorry",404);
        }

        return ApiResponse::success('Success message', 200, [$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserValidator $request, string $id)
    {
        $data = User::find($id);

        $currentValues = $data->getAttributes();

        if (!$data){
            return ApiResponse::error("Coundt Get the user to update!",509);
        }
        if($request->has('roles')){

            $data->roles()->detach();

            $data->assignRole($request->input('roles'));
        }

        $data->fill([
            'name' => $request->name ?? $currentValues["name"],
            'email' => $request->email ?? $currentValues["email"],
            'password' => $request->password ?? $currentValues["password"],
            'phone' => $request->phone ?? $currentValues["phone"],
        ]);

        $data->save();

        return ApiResponse::success("All upddate with no issue !",200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id); // comprueba que existe

        if (!$user) {
            ApiResponse::error("Cant delete a user that i cant find",404);
        }
        $user->roles()->detach();

        User::destroy($user->id);

        return ApiResponse::success("Event no longer in our database!" ,200);
    }
}
