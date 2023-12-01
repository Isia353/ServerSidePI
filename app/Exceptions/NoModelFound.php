<?php

namespace App\Exceptions;

use Exception;

class NoModelFound extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => 'Model not Found Bro',
            'message' => $this->getMessage(),
        ], 404);
    }
}
