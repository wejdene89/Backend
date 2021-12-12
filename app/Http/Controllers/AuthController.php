<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use  App\User;
use  App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\AcceptMail;
class AuthController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','CreateUser','send','AllUsers','DeleteUser','UpdateUser','findemail']]);
    }
     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email','password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    
    public function CreateUser(UserRequest $request)
    {
       $user = User::create($request->all());
       return  $user;
    }
    
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return response()->json(auth()->user());
    }
    public function send()
    {
        return Mail::to("wejdenelabidi89@yahoo.com")->send(new SendMail());
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'role' =>  auth()->user()->role,
            'nom' => auth()->user()->nom,
            'prenom' => auth()->user()->prenom,
        ]);
    }
    public  function  AllUsers()
    {   
        return $users = User::all();
      
    }
    public  function  DeleteUser($id)
    {   
        $user = User::findOrFail($id);
        return $user->delete();
    }
    public  function UpdateUser(Request $request , $id)
    {  
        $user = User::findOrFail($id);
        $user->accepte =  $request->accepte;
        $user->save();
        return   Mail::to($user->email)->send(new AcceptMail());  
      }
      public  function findemail($email)
    {  
        $user =  User::where('email',$email)->first();
        return $user;    
    }
}


