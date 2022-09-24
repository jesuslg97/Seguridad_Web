<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller 
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'alpha','min:2', 'max:20'], //Listo(Noo deja meter nombre con espacion, entiendo que esta bien asi)
            'surname' => ['required', 'alpha','min:2', 'max:40'], //Listo
            'dni' => ['required','regex:/^[0-9]{8}[A-Z]$/i'],//Listo(No se si tiene que ser un DNI valido)
            'email' => ['required', 'email', 'unique:users'], //Listo
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' =>['required'], //Listo
            'phone' => ['nullable','min:9','max:12','regex:/^^[+]{0,1}([0-9]{9,11})$/i'], //Listo
            'country' =>['nullable'], 
            'iban'=> ['required'],
            'about' => ['nullable','min:20','max:250'] //Listo
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        Log::info('Crear Usuario');
        $usuario = new User();
        $usuario->name = $data['name'];
        $usuario->surname = $data['surname'];
        $usuario->dni = $data['dni'];
        $usuario->phone = $data['phone'];
        $usuario->country = $data['country'];
        $usuario->iban= $data['iban'];
        $usuario->about = $data['about'];
        $usuario->email = $data['email'];
        $usuario->password = Hash::make($data['password']);
        
        $usuario->save();

        
        return $usuario;

    }

    public function isValidNif($nif){

        $nifRegEx = '/^[0-9]{8}[A-Z]$/i';
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";

        if (preg_match($nifRegEx, $nif)) {
            return ($letras[(substr($nif, 0, 8) % 23)] == $nif[8]);
        }

        return false;

    }
}
