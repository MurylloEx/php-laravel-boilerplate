<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use \App\Models\User;

class AdminRoleMiddleware
{

  const ROLE_ADMIN = 2;

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    /** @var User */
    $user = auth()->user();
    $canAccess = false;

    if ($user !== null) {
      $canAccess = !!($user->getRole() & self::ROLE_ADMIN);
    }
    
    if (!$canAccess){
      throw new UnauthorizedException(
        'You are not authorized to access this page. ' .  
        'Need Admin role to access this resource.');
    }
    
    return $next($request);
  }

}
