<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $kategori = Kategori::select('id','nama_kategori')->where('status',1)->get();
        $produk = Produk::get();
        return view ("produk.index",compact("kategori","produk"));
    }

    public function insert(Request $req)
    {
        Produk::create($req->except('_token'));
        return redirect ("/produk");
    }

    public function getProdukByKategori($id_kategori)
    {
        $produkByKategori = Produk::where("id_kategori",$id_kategori)->get();
        return $produkByKategori;
    }

    // KATEGORI
    public function kategori()
    {
        $kategori = Kategori::select('id','nama_kategori')->get();
        return view ("produk.kategori",compact("kategori"));
    }

    public function insertKategori(Request $req)
    {
        Kategori::create($req->except('_token'));
        return redirect("/produk/kategori");
    }

}
