<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\User;
use  App\Http\Requests\UserRequest;

class UserController extends Controller
{
   /* public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['CreateUser']]);
    }

    public function CreateUser(UserRequest $request)
    {
       
        return User::create($request->all());
    }
    */
}
