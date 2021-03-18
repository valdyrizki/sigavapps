<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Member;
use Exception;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view("member.index");
    }

    public function getAll()
    {
        return MemberResource::collection(Member::all());
    }

    public function getById()
    {
        
        $status = 'success';
        try{
            $data = Member::find(request()->id);
        }catch(Exception $e){
            $status = 'error';
            $data = $e;
        }
        
        return response()->json([
            'status' => $status,
            'data' => $data
        ]);
    }

    public function store(Request $req)
    {
        $status = 'success';
        $message = 'Member '.$req->nama.' berhasil disimpan';

        try{
            $member = Member::create($req->all());
            $data = $member;
        }catch(Exception $e){
            $status = 'error';
            $message = 'Member '.$req->nama.' Gagal tersimpan';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
    }

    public function update()
    {
        try{
            $member = Member::find(request()->id);
            $member->nama = request()->nama;
            $member->no_hp = request()->no_hp;
            $member->norek = request()->norek;
            $member->bank = request()->bank;
            $member->deskripsi = request()->deskripsi;
            $member->status = request()->status;
            $member->save();

            $msg = "Member berhasil diupdate";
            $status = 'success';
            $data = $member;
        }catch(Exception $e){
            $msg = "Data".request()->name." gagal diupdate";
            $status = "error";
            $data = $e;
        }

        return response()->json([
            'msg' => $msg,
            'status' => $status,
            'data' => $data
        ]);
    }

    public function delete(Request $req)
    {
        $status = 'success';
        $message = 'Member '.$req->nama.' berhasil dihapus';

        try{
            Member::where('id', $req->id)->delete();
            $data = $req;
        }catch(Exception $e){
            $status = 'error';
            $message = 'Member '.$req->nama.' gagal dihapus';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
    }
    
}
