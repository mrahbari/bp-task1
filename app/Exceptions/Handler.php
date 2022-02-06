<?php

namespace App\Exceptions;

use App\Base\Traits\JsonExceptionHandlerTrait;
use App\Base\Traits\JsonResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonResponseTrait;
    use JsonExceptionHandlerTrait;

    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {
        //print_r(get_class($e));

        //Render an exception into a json response
        if ($this->isJsonApi($request)) {
            return $this->renderJsonApi($request, $e);
        }

        //Render an exception into web response
        return parent::render($request, $e);
    }
}
