<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $req)
    {
        $validate = $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        Auth::attempt($validate,$req->remember);
        if(Auth::check()){
            return redirect()->intended('/');
        }else{
            return back()->with('error','Email / Password tidak valid');
        }
    }
}
