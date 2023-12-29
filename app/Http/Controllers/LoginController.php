<?php

namespace App\Http\Controllers;

use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Exception;

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
    public function InicioNormal(Request $request){
        $request = $request->input();
        $credenciales = [
            'Username' => $request['Username'],
            'password' => $request['Password']
        ];

        try{
            if(Auth::attempt($credenciales)){
                if(auth()->user()->Enabled == 0){
                    throw new Exception('Error al iniciar sesión.'); 
                }

                return response()->json([
                    'redirect' => (route('Usuario'))
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'mensaje' => ($e->getMessage())
            ]);
        }

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
        
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        /*
        // SI LA APP EN GOOGLE CLOUD ESTÁ CONFIGURADA COMO USO INTERNO, NO ES NECESARIO REALIZAR ESTA VERIFICACIÓN
        // Para este punto, no buscará en la BD. La verificación siguiente también sirve para cubrir este caso.
        if (!Str::endsWith($user->email, '@camanchaca.cl')) {
            $mensaje = 'La cuenta de no está registrada en el sistema';
        
            return redirect()->intended(route('login'))
                ->with([
                    'mensaje' => $mensaje,
                ]);
        }
        */

        
        try{

            $usuarioLogear = Usuario::where('Email','=',$googleUser->getEmail())
                                ->first();
            if(!$usuarioLogear){
                throw new Exception('Usuario no encontrado.'); 
            }

            if($usuarioLogear->Enabled == 0){
                throw new Exception('Error al iniciar sesión.'); 
            }
            Auth::login($usuarioLogear);
            return redirect()->intended(route('Usuario'));
        }catch(Exception $e){
            return redirect()->intended(route('login'))
                ->with([
                    'mensaje' => $e->getMessage(),
                ]);
        }
    }

    //Cierra la sesión de Auth
    public function CerrarSesion(){
        Auth::logout();
        return redirect()->intended(route('login'));
    }
}
