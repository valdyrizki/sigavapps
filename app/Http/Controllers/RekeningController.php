<?php

namespace App\Http\Controllers;

use App\Rekening;
use Exception;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function store(Request $req)
    {
        $status = 'success';
        $message = 'Rekening '.$req->nama.' berhasil disimpan';

        try{
            $member = Rekening::create($req->all());
            $data = $member;
        }catch(Exception $e){
            $status = 'error';
            $message = 'Rekening '.$req->nama.' Gagal tersimpan';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
    }

    public function getAll()
    {
        $rekening = Rekening::get();
        return $rekening;
    }

    public function getByNorek()
    {
        $status = 'success';
        try{
            $data = Rekening::whereNorek(request()->norek)->first();
        }catch(Exception $e){
            $status = 'error';
            $data = $e;
        }
        
        return response()->json([
            'status' => $status,
            'data' => $data
        ]);
    }
}
