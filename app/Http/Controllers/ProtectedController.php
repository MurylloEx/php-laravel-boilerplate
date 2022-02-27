<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProtectedController extends Controller
{

  public function __construct() {}

  public function doFetchProtected(){
    return response()->json(['hello' => 'world']);
  }
  
}
