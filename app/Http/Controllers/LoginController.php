<?php

namespace App\Http\Controllers;

use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;


class LoginController extends Controller
{
    public function Index(){

        return View('login.login');
    }

    //Iniciar sesión con usuario y contraseña
    public function InicioNormal(){

    }

    // Envía la solicitud a Google
    public function redirectToGoogle()
    {
        if(Auth::check()) redirect()->intended(route('Usuario'));
        return Socialite::driver('google')->redirect();
    }
    // Respuesta desde Google, iniciar sesión
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $usuarioLogear = Usuario::where('Email','=',$googleUser->getEmail())
                                ->first();

        if($usuarioLogear){
            Auth::login($usuarioLogear);
            return redirect()->intended(route('Usuario'));
        }

        

        return redirect()->intended(route('Login'));
    }

    //Cierra la sesión de Auth
    public function CerrarSesion(){
        Auth::logout();
    }
}
