<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Nacionalidades;
use App\Models\Generos;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
     
      public function showRegistrationForm()
    {
        $nacionalidades = Nacionalidades::get();
        $generos        = Generos::get();
        return view('auth.register', compact('nacionalidades','generos'));
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'             => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'username'         => 'required|string|max:8|unique:users',
            'direccion'        => 'required|string|max:255',
            'nacionalidad_id'  => 'required',
            'genero_id'        => 'required',
            'telefono'         => 'required|max:11',
            'fecha_nacimiento' => 'required|date|max:11',
            'email'            => 'required|string|email|max:255|unique:users',
            'password'         => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        return User::create([
            'name'             => $data['name'],
            'last_name'        => $data['last_name'],
            'username'         => $data['username'],
            'direccion'        => $data['direccion'],
            'telefono'         => $data['telefono'],
            'genero_id'        => $data['genero_id'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'nacionalidad_id'  => $data['nacionalidad_id'],
            'email'            => $data['email'],
            'password'         => bcrypt($data['password']),
        ]);
    }
}
