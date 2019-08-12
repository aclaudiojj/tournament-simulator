<?php

namespace Api\Exceptions;

class ApiException extends \Exception
{

    public function render()
    {
        return response()->json([
            'error' => $this->getMessage()
        ], 422);
    }
}