<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Base\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\View\ViewException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Swift_TransportException;
use Throwable;

trait JsonExceptionHandlerTrait
{
    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     */
    protected function renderJsonApi(Request $request, Throwable $e): JsonResponse
    {
        switch (true) {
            case $this->isValidationException($e):
                $returnValue = $this->validationError($e, trans('exception.validation.exception'));
                break;
            case $this->isTokenMismatchException($e):
                $returnValue = $this->tokenMismatchError($e, trans('exception.token.mismatch.exception'));
                break;
            case $this->isQueryException($e):
                $returnValue = $this->queryError($e, trans('exception.query.exception'));
                break;
            case $this->isInternalServerException($e):
                $returnValue = $this->internalServerError($e, trans('exception.internal.server.exception'));
                break;
            case $this->isModelNotFoundException($e):
                $returnValue = $this->modelNotfoundError($e, trans('exception.model.not.found.exception'));
                break;
            case $this->isOAuthServerException($e):
                $returnValue = $this->oAuthServerError($e, trans('exception.oauth.server.exception'));
                break;
            case $this->isAuthorizationException($e):
                $returnValue = $this->authorizationError($e, trans('exception.authorization.exception'));
                break;
            case $this->isAuthenticationException($e):
                $returnValue = $this->authenticationError($e, trans('exception.authentication.exception'));
                break;
            case $this->isMethodNotAllowedHttpException($e):
                $returnValue = $this->methodNotAllowedHttpError($e, trans('exception.method.not.allowed.http.exception'));
                break;
            case $this->isNotFoundHttpException($e):
                $returnValue = $this->notFoundHttpError($e, trans('exception.not.found.http.exception'));
                break;
            case $this->isMissingScopeException($e):
                $returnValue = $this->missingScopeError($e, trans('exception.missing.scope.exception'));
                break;
            case $this->isViewException($e):
                $returnValue = $this->viewError($e, trans('exception.view.exception'));
                break;
            case $this->isSwiftTransportException($e):
                $returnValue = $this->swiftTransportError($e, trans('exception.swift.transport.exception'));
                break;

            default:
                $returnValue = $this->badRequestError($e, trans('exception.bad.request.exception'));
        }
        return $returnValue;
    }

    // Error Responses
    private function validationError(Throwable $e, $message = "There was an error of validation", $statusAbb = "VALIDATION_EXCEPTION", $statusCode = 422)
    {
        $compactMessage = '';
        if ($e instanceof ValidationException) {

            /*$validationErrors = $e->validator->errors()->getMessages();
            $validationErrors = array_map(function ($error) {
                return array_map(function ($message) {
                    return $message;
                }, $error);
            }, $validationErrors);*/

            $validationErrors = $e->validator->errors()->getMessages();
            if (is_array($validationErrors))
                $validationErrors = reset($validationErrors);   //Get the first element of an array
            else
                $validationErrors = $e->getMessage();

            return $this->jsonResponse(["error" => $validationErrors, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
        }
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function tokenMismatchError(Throwable $e, $message = "There was an mismatch for generated token", $statusAbb = "TOKEN_MISMATCH", $statusCode = 400)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function queryError(Throwable $e, $message = "There was an mistake in given query", $statusAbb = "QUERY_EXCEPTION", $statusCode = 400)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function swiftTransportError(Throwable $e, $message = "There was an error swift transport on your request", $statusAbb = "SWIFT_TRANSPORT_EXCEPTION", $statusCode = 400)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function viewError(Throwable $e, $message = "There was an error on view file", $statusAbb = "VIEW_EXCEPTION", $statusCode = 400)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function internalServerError(Throwable $e, $message = "There was an internal server error in your application", $statusAbb = "INTERNAL_SERVER_ERROR", $statusCode = 500)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function badRequestError(Throwable $e, $message = "Bad request", $statusAbb = "BAD_REQUEST", $statusCode = 400)
    {
        $message = !empty($e->getMessage()) ? $e->getMessage() : $message; //Just For Bad Request!!!
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function modelNotFoundError(Throwable $e, $message = "Model Not Found", $statusAbb = "MODEL_NOT_FOUND", $statusCode = 404)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function oAuthServerError(Throwable $e, $message = "There was an error authenticating your request", $statusAbb = "BAD_AUTH", $statusCode = 401)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function authorizationError(Throwable $e, $message = "There was an error authenticating your request", $statusAbb = "BAD_AUTH", $statusCode = 401)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function authenticationError(Throwable $e, $message = "There was an error authenticating your request", $statusAbb = "BAD_AUTH", $statusCode = 401)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function methodNotAllowedHttpError(Throwable $e, $message = "The requested method is not allowed for this request", $statusAbb = "BAD_METHOD", $statusCode = 400)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function notFoundHttpError(Throwable $e, $message = "The requested route can not be found on the server", $statusAbb = "BAD_ROUTE", $statusCode = 404)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    private function missingScopeError(Throwable $e, $message = "You don't have the right to access this route", $statusAbb = "SCOPE_NOT_FOUND", $statusCode = 401)
    {
        return $this->jsonResponse(['error' => $message, 'debug' => get_class($e) . " " . $e->getMessage()], $statusAbb, $statusCode);
    }

    // Exception Handlers
    private function isValidationException(Throwable $e): bool
    {
        return $e instanceof ValidationException;
    }

    private function isTokenMismatchException(Throwable $e): bool
    {
        return $e instanceof TokenMismatchException;
    }

    private function isQueryException(Throwable $e): bool
    {
        return $e instanceof QueryException;
    }

    private function isSwiftTransportException(Throwable $e): bool
    {
        return $e instanceof Swift_TransportException;
    }

    private function isViewException(Throwable $e): bool
    {
        return $e instanceof ViewException;
    }

    private function isInternalServerException(Throwable $e): bool
    {
        return $e instanceof InternalErrorException || $e instanceof FatalError;
    }

    private function isModelNotFoundException(Throwable $e): bool
    {
        return $e instanceof ModelNotFoundException;
    }

    private function isOAuthServerException(Throwable $e): bool
    {
        return $e instanceof AuthorizationException;
    }

    private function isAuthorizationException(Throwable $e): bool
    {
        return $e instanceof AuthorizationException/* || $e instanceof Error*/ ;
    }

    private function isAuthenticationException(Throwable $e): bool
    {
        return $e instanceof AuthenticationException;
    }

    private function isMethodNotAllowedHttpException(Throwable $e): bool
    {
        return $e instanceof MethodNotAllowedHttpException;
    }

    private function isNotFoundHttpException(Throwable $e): bool
    {
        return $e instanceof NotFoundHttpException;
    }

    private function isMissingScopeException(Throwable $e): bool
    {
        return false;
        //return $e instanceof MissingScopeException;
    }

    /**
     * @param array $payload
     * @param $statusAbb
     * @param int $statusCode
     * @return mixed
     */
    private function jsonResponse(array $payload, $statusAbb, int $statusCode = 404)
    {
        if (config('app.env') === false && !empty($payload['debug']))
            unset($payload['debug']);

        if (!empty($statusAbb))
            $payload = @array_merge($payload, ['code' => $statusAbb]);

        return $this->apiException($payload, $statusCode);
    }

    /**
     * Determines if request is an api call.
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isJsonApi(Request $request): bool
    {
        return
            strpos($request->getUri(), '/oauth/token') !== false ||
            strpos($request->getUri(), '/api/') !== false ||
            $request->expectsJson() ||
            $request->wantsJson() ||
            ($request->ajax() && !$request->pjax() && $request->acceptsAnyContentType());
    }
}
