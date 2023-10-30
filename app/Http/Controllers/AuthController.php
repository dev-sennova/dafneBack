<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request) {
      $request->validate([
       'email' => 'required|string|email',
       'password' => 'required|string',
       //'remember_me' => 'boolean'
    ]);
    $credentials = request(['email', 'password']);
      if(!Auth::attempt($credentials))
      return response()->json([
      'message' => 'Unauthorized'
    ], 401);
    $user = $request->user();
    $tokenResult = $user->createToken('Personal Access Token');
    $token = $tokenResult->token;


    if ($request->remember_me)
    $token->expires_at = Carbon::now()->addWeeks(1);
    $token->save();

    return response()->json([
      'access_token' => $tokenResult->accessToken,
      'token_type' => 'Bearer',
      'expires_at' => Carbon::parse(
       $tokenResult->token->expires_at
      )->toDateTimeString(),
      'id_usuario' => $user->id,
      'rol' => $user->rol // Agrega el campo 'rol' a la respuesta
    ]);
  }
  public function register(Request $request)
  {
    $request->validate([
    'name' => 'required|string',
    'email' => 'required|string|email|unique:users',
    'rol' => 'required|integer',
    'password' => 'required|string'
  ]);
   $user = new User;
   $user->name = $request->name;
   $user->email = $request->email;
   $user->rol = $request->rol;
   $user->password = bcrypt($request->password);
   $user->save();
   return response()->json([
    'estado' => 'Ok',
    'message' => 'Usuario creado exitosamente!'
   ], 201);
  }
  public function logout(Request $request)
  {
    $request->user()->token()->revoke();
    return response()->json([
     'message' => 'Successfully logged out'
    ]);
  }
  /**
  * Get the authenticated User
  *
  * @return [json] user object
  */
    public function user(Request $request)
    {
      return response()->json($request->user());
    }
  }
