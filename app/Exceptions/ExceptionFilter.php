<?php

namespace App\Exceptions;

use Throwable;
use Exception;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class ExceptionFilter extends ExceptionHandler
{

  /**
   * A list of the exception types that are not reported.
   *
   * @var array<int, class-string<Throwable>>
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
    //
  ];

  public function render($request, Throwable $exception)
  {
    if ($exception instanceof Exception){
      $isValidStatusCode = $exception->getCode() != 0;
      $statusCode = $isValidStatusCode ? $exception->getCode() : 500;
      
      return response()->json($exception, $statusCode);
    }
    throw new Exception('Something went wrong in webservice.');
  }

  /**
   * Register the exception handling callbacks for the application.
   *
   * @return void
   */
  public function register()
  {
    $this->reportable(function (Throwable $e) {
      Log::error($e->getMessage());
    });
  }

}
