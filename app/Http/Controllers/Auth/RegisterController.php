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
        //https://regexr.com/3c53v
        return Validator::make($data, [
            'nombre' => ['required', 'regex:/^[a-zA-Z\s]*$/','min:2', 'max:20'], //Listo
            'apellido' => ['required', 'regex:/^[a-zA-Z\s]*$/','min:2', 'max:40'], //Listo
            'dni' => ['required','regex:/^[0-9]{8}[A-Z]$/i'],//Listo
            'email' => ['required', 'email', 'unique:users'], //Listo
            'password' => ['required', 'min:10', 'confirmed','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{10,}$/i'],//Listo
            'password_confirmation' =>['required'], //Listo
            'telefono' => ['nullable','min:9','max:12','regex:/^[+]{1}([0-9]{9,11})$/i'], //Listo
            'country' =>['nullable'], //Listo
            'iban'=> ['required','regex:/^([a-zA-Z]{2})\s*\t*(\d{2})\s*\t*(\d{4})\s*\t*(\d{4})\s*\t*(\d{2})\s*\t*(\d{10})$/i'], //Listo
            'sobreti' => ['nullable','min:20','max:250'] //Listo
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
        
        $usuario = new User();
        $usuario->name = $data['nombre'];
        $usuario->surname = $data['apellido'];
        $usuario->dni = $data['dni'];
        $usuario->phone = $data['telefono'];
        $usuario->country = $data['country'];
        $usuario->iban= $data['iban'];
        $usuario->about = $data['sobreti'];
        $usuario->email = $data['email'];
        $usuario->password = Hash::make($data['password']);
        
        $usuario->save();

        
        return $usuario;

    }

}
