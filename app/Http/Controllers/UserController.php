<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// Aqui se asignan o se quitan roles
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
        ];



        $user = User::create($data);

        return response()->json(['message' => 'Actualizado con exito con id ->'.$user->id],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userRoute = User::with('zone')->find($user->id);


        return $userRoute;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $data = User::find($user->id);

       // DB::table('model_has_roles')->where('model_id',$id)->delete();

      //  $data->assignRole($request->input('roles'));
        $data->fill($request->all());

        $data->save();

        return response()->json(['message' => 'Actualizado con exito'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::find($user->id); // comprueba que existe

        User::destroy($user->id);

        return response()->json(['message' => 'Borrado con exito'],200);
    }
}
