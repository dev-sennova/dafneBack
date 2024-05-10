<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\RegistroMailable;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

  public function login(Request $request)
  {
      $request->validate([
          'email' => 'required|string|email',
          'password' => 'required|string',
      ]);
  
      $credentials = request(['email', 'password']);
  
      if (!Auth::attempt($credentials)) {
          return response()->json(['message' => 'Unauthorized'], 401);
      }
  
      $user = Auth::user();
  
      if (!$user->email_verified_at) {
        return response()->json(['error_code' => 'email_not_verified', 'message' => 'Debe verificar su correo electrónico ingresando su PIN'], 401);
    }
  
      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
  
      if ($request->remember_me) {
          $token->expires_at = Carbon::now()->addWeeks(1);
      }
  
      $token->save();
  
      return response()->json([
          'access_token' => $tokenResult->accessToken,
          'token_type' => 'Bearer',
          'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
          'id_usuario' => $user->id,
          'nombre_usuario' => $user->name,
          'email_usuario' => $user->email,
          'rol' => $user->rol
      ]);
  }
  
  public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'rol' => 'required|integer',
        'gestor' => 'required|integer',
        'password' => 'required|string'
    ]);

    // Generar un PIN de 6 dígitos
    $pin = mt_rand(100000, 999999);
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->rol = $request->rol;
    $user->gestor = $request->gestor;
    $user->pin = $pin;
    $user->password = bcrypt($request->password);

    try {
      Mail::to($user->email)->send(new RegistroMailable($user->pin,$user->name));
    } catch (\Exception $e) {
      \Log::error('Error al enviar el correo electrónico: ' . $e->getMessage());

      return response()->json([
          'estado' => 'Error',
          'message' => 'Error al enviar el correo electrónico.'
      ], 500);
    }
  
    $user->save();

    return response()->json([
        'estado' => 'Ok',
        'message' => 'Usuario creado exitosamente!'
    ], 201);
}

public function resendEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error_code' => 'user_not_found', 'message' => 'Usuario no encontrado'], 404);
    }

    Mail::to($user->email)->send(new RegistroMailable($user->pin,$user->name));

    return response()->json(['message' => 'El correo ha sido reenviado correctamente'], 200);

}


public function verifyEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'pin' => 'required|digits:6',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error_code' => 'user_not_found', 'message' => 'Usuario no encontrado'], 404);
    }

    if ($user->pin != $request->pin) {
        return response()->json(['error_code' => 'invalid_pin', 'message' => 'PIN incorrecto'], 401);
    }

    // Marcar el correo electrónico como verificado
    $user->email_verified_at = now();
    $user->save();

    // Crear un token de acceso
    $tokenResult = $user->createToken('Personal Access Token');
    $token = $tokenResult->token;

    if ($request->remember_me) {
        $token->expires_at = Carbon::now()->addWeeks(1);
    }

    $token->save();

    return response()->json([
        'access_token' => $tokenResult->accessToken,
        'token_type' => 'Bearer',
        'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        'id_usuario' => $user->id,
        'nombre_usuario' => $user->name,
        'email_usuario' => $user->email,
        'rol' => $user->rol
    ]);
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
