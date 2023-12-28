<?php

namespace App\Http\Controllers;

use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;


class LoginController extends Controller
{
    public function Index(Request $request){
        $mensaje = '';
        if($request->session()->get('mensaje') != null){
            $mensaje = $request->session()->get('mensaje');
        } 
        return View('login.login')->with([
            'mensaje' => $mensaje
        ]);
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
        
        /*        
        $dominio =  $googleUser->user['hd'];

        if ($dominio != 'camanchaca.cl') {
            $mensaje = 'La cuenta de Google no pertenece a Camanchaca';
        
            return redirect()->intended(route('login'))
                ->with([
                    'mensaje' => $mensaje,
                ]);
        }
        */

        $usuarioLogear = Usuario::where('Email','=',$googleUser->getEmail())
                                ->first();

        if($usuarioLogear){
            Auth::login($usuarioLogear);
            return redirect()->intended(route('Usuario'));
        }

        

        return redirect()->intended(route('login'));
    }

    //Cierra la sesión de Auth
    public function CerrarSesion(){
        Auth::logout();
        return redirect()->intended(route('login'));
    }
}
