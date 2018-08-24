<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Metodo encargado de obtener la información del usuario
    public function handleProviderCallback($provider)
    {
        try {
            // Obtenemos los datos del usuario
            $social_user = Socialite::driver($provider)->user();
            // Comprobamos si el usuario ya existe
            $user = User::where('email', $social_user->email)->firstOrFail();
            if ($user) {
                return $this->authAndRedirect($user); // Login y redirección
            }
        } catch (Exception | ClientException $e) {
            return redirect()->to('/login')->withErrors(['email' => "No existe el email en nuestra base de datos"]);
        }
    }



    
    // Login y redirección
    public function authAndRedirect($user)
    {
        Auth::login($user);

        return redirect()->to('/home');
    }
}

// public function handleProviderCallback($provider)
//     {
//         try{
//             $user = Socialite::driver($provider)->user();
//         } catch (\GuzzleHttp\Exception\ClientException $e) {
//             abort(403, 'Unauthorized action.');
//             return redirect()->to('/');
//         }
//         $attributes = [
//             'provider' => $provider,
//             'provider_id' => $user->getId(),
//             'name' => $user->getName(),
//             'email' => $user->getEmail(),
//             'password' => isset($attributes['password']) ? $attributes['password'] : bcrypt(str_random(16))
 
//         ];
 
//         $user = User::where('provider_id', $user->getId() )->first();
//         if (!$user){
//             try{
//                 $user=  User::create($attributes);
//             }catch (ValidationException $e){
//               return redirect()->to('/auth/login');
//             }
//         }
 
//         $this->guard()->login($user);
//        return redirect()->to($this->redirectTo);
 
//     }
