<?php

namespace App\Exceptions\Http;

use Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BadRequestException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report(): void
    {
        Log::error($this->getMessage(), $this->getTrace());
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  Request  $request
     * @return Response
     */
    public function render($request): Response
    {
        return response([], 400);
    }
}
