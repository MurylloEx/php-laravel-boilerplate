<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

  public function __construct() {}

  public function doFetchUsers(){
    return User::all();
  }

  public function doFetchLoggedUser(){
    return auth()->user();
  }

  public function doFetchUserById(int $id){
    return User::query()
      ->first()
      ->where('id', '=', $id)
      ->get();
  }

  public function doFetchUserWithAdminRole(){
    return User::query()
      ->where('role', '&', 2)
      ->get();
  }

  public function doFetchUserWithUserRole(){
    return User::query()
      ->where('role', '&', 1)
      ->get();
  }

}
