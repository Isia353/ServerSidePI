<?php

namespace App\Exceptions;

use App\Http\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\NoModelFound;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });


    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NoModelFound) {
            return response()->json([
                'error' => 'Media not Found Exception',
                'message' => $e->getMessage(),
            ], 404);
        }

        return parent::render($request, $e);
    }


}
