<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class UserRoleMiddleware
{

  const ROLE_USER = 1;

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next) {
    /** @var User */
    $user = auth()->user();
    $canAccess = false;

    if ($user !== null) {
      $canAccess = !!($user->getRole() & self::ROLE_USER);
    }
    
    if (!$canAccess){
      throw new UnauthorizedException(
        'You are not authorized to access this page. ' .  
        'Need User role to access this resource.');
    }

    return $next($request);
  }

}
