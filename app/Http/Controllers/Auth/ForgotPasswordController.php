<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use DB;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            $token = Str::random(60);
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => bcrypt($token),
                    'created_at' => Carbon::now(),
                ]
            );

            Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

            return back()->with('status', __('Se ha enviado el enlace para restablecer la contraseña a su correo electrónico.'));
        }

        return back()->withErrors(
            ['email' => __('No podemos encontrar un usuario con esa dirección de correo electrónico.')]
        );
    }
}
