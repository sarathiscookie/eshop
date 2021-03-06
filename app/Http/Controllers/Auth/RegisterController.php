<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Roleuser;
use Carbon\Carbon;
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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'role' => 'required|not_in:0',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'address' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'address' => $data['address'],
            'alias' => str_slug($data['name'].' '.$data['lastname'].' '.Carbon::now()),
            'password' => bcrypt($data['password']),
        ]);

        $roleId = Role::select('id', 'role')
            ->where('role', $data['role'])
            ->first();

        if($roleId->role == 'seller')
        {
            $this->redirectTo = '/seller/home';
        }
        elseif($roleId->role == 'buyer')
        {
            $this->redirectTo = '/buyer/home';
        }

        Roleuser::create([
            'user_id' => $user->id,
            'role_id' => $roleId->id,
        ]);

        return $user;
    }

}
