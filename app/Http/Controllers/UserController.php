<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("user.index",compact("users"));
    }

    public function store(Request $req)
    {
        $status = 'success';
        $message = 'User '.$req->name.' berhasil disimpan';

        try{
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->name),
                'level' => $req->level
            ]);
        }catch(Exception $e){
            $status = 'error';
            $message = 'User '.$req->name.' Gagal tersimpan';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $user
        ]);
    }

    public function getbyid($id)
    {
        $user = User::select('name','email','level')->find($id);
        return $user;
    }

    public function insert()
    {
        try{
            $user = User::create([
                'name' => request()->name,
                'email' => request()->email,
                'password' => Hash::make(request()->password),
                'level' => request()->level
            ]);
            $msg = "User ".$user->name." berhasil ditambahkan sebagai ".getRole($user->level);
            $status = 'success';
            $data = $user;
        }catch(Exception $e){
            $msg = "Data".request()->name." gagal ditambahkan";
            $status = "error";
            $data = request();
        }

        return response()->json([
            'msg' => $msg,
            'status' => $status,
            'data' => $data
        ]);
    }

    public function update()
    {
        try{
            $user = User::find(request()->id);
            $user->name = request()->name;
            $user->email = request()->email;
            $user->password = Hash::make(request()->password);
            $user->level = request()->level;
            $user->save();

            $msg = "User ".$user->name." berhasil diupdate";
            $status = 'success';
            $data = $user;
        }catch(Exception $e){
            $msg = "Data".request()->name." gagal diupdate";
            $status = "error";
            $data = request();
        }

        return response()->json([
            'msg' => $msg,
            'status' => $status,
            'data' => $data
        ]);
    }

    public function checkPass(Request $req)
    {
        try{
            $user = User::select('password')->find($req->id);
            if(Hash::check($req->password, $user->password)){
                return response()->json([
                    'status' => 'success'
                ]);
            }else{
                return response()->json([
                    'status' => 'error'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function getUser()
    {
        $user = User::get();
        return $user;
    }
}
