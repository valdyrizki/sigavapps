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
        $produkByKategori = Produk::where("id_kategori",$id_kategori)->orderBy('nama_produk', 'asc')->get();
        return $produkByKategori;
    }

    public function getAllProduk()
    {
        $allProduk = Produk::orderBy('nama_produk', 'asc')->get();
        return $allProduk;
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

    public function stok(){
        $kategori = Kategori::select('id','nama_kategori')->get();
        return view("produk.stok",compact("kategori"));
    }

    public function addStok()
    {
        $produk = Produk::find(request()->id_produk);
        $produk->stok = $produk->stok + request()->tambah_stok;
        $produk->save();

        return response()->json([
            'message' => 'Tambah Stok Berhasil'
        ]);
    }
}
