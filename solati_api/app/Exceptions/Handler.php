<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use App\Helpers\LogActivity;

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
    public function register()
  {

    $this->renderable(function (Throwable $exception, $request) {
      return $this->handleApiException($request, $exception);
    });

    $this->renderable(function (ModelNotFoundException $exception, $request) {
      return $this->handleApiException($request, $exception);
    });

    $this->renderable(function (NotFoundHttpException $exception, $request) {
      return $this->handleApiException($request, $exception);
    });
  }

  public function render($request, Throwable $exception)
  {
    if ($request->wantsJson()) {   //add Accept: application/json in request
      return $this->handleApiException($request, $exception);
    } else {
      $retval = parent::render($request, $exception);
    }

    return $retval;
  }

  private function handleApiException($request, Throwable $exception)
  {

    $oException = $this->prepareException($exception);

    if ($exception instanceof HttpResponseException) {
      $oException = $exception->getResponse();
    }

    if ($exception instanceof ModelNotFoundException) {
      $oException = $exception;
    }

    if ($exception instanceof NotFoundHttpException) {
      $oException = $exception;
    }

    if ($exception instanceof AuthenticationException) {
      $oException = $this->unauthenticated($request, $exception);
    }

    if ($exception instanceof Throwable) {
      $oException = $exception;
    }

    if ($exception instanceof ValidationException) {
      $oException = $this->convertValidationExceptionToResponse($exception, $request);
    }

    return $this->customApiResponse($oException);
  }


  private function customApiResponse($exception)
  {
    if (method_exists($exception, 'getStatusCode')) {
      $statusCode = $exception->getStatusCode();
    } else {
      $statusCode = 500;
    }

    $response = [];

    $response['status'] = 'Error';
    $response['data'] = 'null';

    switch ($statusCode) {
      case 401:
        $response['message'] = 'Unauthorized';
        $response['errors'] = $exception->getMessage();
        break;
      case 403:
        $response['message'] = 'Forbidden';
        $response['errors'] = $exception->getMessage();
        break;
      case 404:
        $response['message'] = 'Not Found';
        $response['errors'] = $exception->getMessage();
        break;
      case 405:
        $response['message'] = 'Method Not Allowed';
        $response['errors'] = $exception->getMessage();
        break;
      case 422:
        $response['message'] = $exception->original['message'];
        $response['errors'] = $exception->original['errors'];
        break;
      default:
        $response['message'] = 'Server error';
        //$response['errors'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
        $response['errors'] = $exception->getMessage();

        break;
    }

    if (config('app.debug')) {
      $response['code'] = $exception->getCode();
      $response['trace'] = $exception->getTrace();
    }

    LogActivity::addToLog($response['message'], 'false', '', '', "{$response['errors']} - Code: {$statusCode}");
    $response['code'] = $statusCode;

    return response()->json($response, $statusCode);
  }
}
