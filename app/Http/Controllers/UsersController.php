<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $data['request'] = $request;

        return view('login', $data);
    }

    // Do Login
    public function doLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $check = DB::table('users')
                ->where('email', $email)
                ->first();
        
        if($check)
        {
            if(Hash::check($password, $check->password)){
                $data = array(
                    'name' => $check->name,
                    'email' => $check->email,
                    'role' => $check->role
                );

                $request->session()->put('login_data', $data);

                return redirect('home');
            }else{
                $request->session()->flash('errors', 'Email or Password Incorrect!');
    
                return redirect('login');
            }
        }else{
            $request->session()->flash('errors', 'Email or Password Incorrect!');

            return redirect('login');
        }
    }

    // Log Out
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect('login');
    }
}
