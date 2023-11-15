<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoerOrReader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();


        //$id = $request->route('user');

        // Check if the model with the given ID exists
        //  $item = User::find($id);

        //     if ($request->route()->getName() === 'user.show' && !$item) {
        //         throw new UserNotFoundException('No existe dicho usuario'); // Replace with your custom exception
        //   }
        // Check if the user is an admin


        if ($user->isAdmin()) {
            return $next($request); // Admins have unrestricted access
        }

        // For non-admin users, check if they are trying to access their own data
        //  if ($user->id == $request->route('user')) {
        //    return $next($request);
        //}

        return response(['response : You only can List and Search!'], 403);
    }
}
