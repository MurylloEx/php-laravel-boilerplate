<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

  public function __construct() {
    $this->middleware('auth:api', [
      'except' => ['doAuthenticate']
    ]);
  }

  public function doAuthenticate(Request $request) {
    $credentials = $request->all(['email', 'password']);
    
    if (!$token = auth('api')->attempt($credentials)){
      throw new UnauthorizedException('User provided invalid credentials. Access Denied.');
    }

    return response()->json([
      'token' => $token
    ]);
  }

}
