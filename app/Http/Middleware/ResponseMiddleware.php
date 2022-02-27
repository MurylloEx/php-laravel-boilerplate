<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class ResponseMiddleware
{

  public function getStatus(Exception $exception){
    $className = get_class($exception);
    $classNameParts = explode('\\', $className);
    $classNameFiltered = Arr::last($classNameParts);
    $classNameSnakeCase = preg_replace('/(?<!^)[A-Z]/', '_$0', $classNameFiltered);
    return 'status_' . strtolower($classNameSnakeCase);
  }

  public function handle(Request $request, Closure $next)
  {
    $response = $next($request);
    $content = $response->getOriginalContent();
    $statusCode = $response->getStatusCode();

    $isJsonResponse = $response->headers->get('Content-Type') === 'application/json';
    $isExceptionResponse = $content instanceof Exception;

    if ($isJsonResponse){
      $newContent = array(
        'timestamp' => round(microtime(true) * 1000),
        'path' => $request->path(),
        'error' => $isExceptionResponse,
        'status' => $statusCode,
        'code' => $isExceptionResponse ? $this->getStatus($content) : 'status_success',
        'response' => $isExceptionResponse ? $content->getMessage() : $content
      );

      $response->setContent(json_encode($newContent));
    }

    return $response;
  }

}
