<?php

namespace App\Http\Controllers;

use App\DetailProduk;
use App\HistoryProduk;
use App\HistoryStok;
use App\Http\Resources\HistoryProdukResource;
use App\Http\Resources\HistoryStokResource;
use App\Http\Resources\ProdukResource;
use App\Kategori;
use App\Produk;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        // $kategori = Kategori::select('id','nama_kategori')->where('status',1)->get();
        // $produk = Produk::get();
        return view ("produk.index");
    }

    public function insert(Request $req)
    {
        $status = 'success';
        $message = 'Produk '.$req->nama_produk.' berhasil disimpan';
        
        try{
            $data = Produk::create($req->all());
        }catch(Exception $e){
            report($e);
            $status = 'error';
            $message = 'Produk Gagal tersimpan';
            $data = $e;
        }

        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);
        
    }

    public function getById()
    {
        $produkById = Produk::find(request()->id);
        return $produkById;
    }

    public function getByKategori($id_kategori)
    {
        $produkByKategori = Produk::where("id_kategori",$id_kategori)->whereStatus(1)->orderBy('nama_produk', 'asc')->get();
        return $produkByKategori;
    }

    public function getProdukByInput($input)
    {
        $produkByInput = Produk::where('nama_produk', 'LIKE', "%{$input}%")->whereStatus(1)->orderBy('nama_produk', 'asc')->get();
        return $produkByInput;
    }

    public function getProdukByCategoryInput($id_kategori,$input)
    {
        $produkByCategoryInput = Produk::where('nama_produk', 'LIKE', "%{$input}%")->where("id_kategori",$id_kategori)->whereStatus(1)->orderBy('nama_produk', 'asc')->get();
        return $produkByCategoryInput;
    }

    public function get()
    {
        $produk = Produk::orderBy('nama_produk', 'asc')->whereStatus(1)->get();
        return $produk;
    }

    public function getHistoryStokIn()
    {
        $hist = DB::select("
        SELECT A.*, B.nama_produk 
        FROM history_stok A
        INNER JOIN produk B ON A.id_produk = B.id
        WHERE A.before < A.after 
        ORDER BY A.id DESC
        
         ", []);
        // $hist = HistoryStok::join("produk","history_stok.id_produk","=","produk.id")->select("history_stok.*","produk.nama_produk")->where("history_stok.before",">","history_stok.after")->orderBy("history_stok.id","DESC")->get();
        return HistoryStokResource::collection($hist);
    }

    public function getHistoryStokOut()
    {
        $hist = DB::select("
        SELECT A.*, B.nama_produk 
        FROM history_stok A
        INNER JOIN produk B ON A.id_produk = B.id
        WHERE A.before > A.after 
        ORDER BY A.id DESC
        
         ", []);
         return HistoryStokResource::collection($hist);
    }

    public function getAll()
    {
        $allProduk = Produk::join('product_category', 'produk.id_kategori','=','product_category.id')->select('produk.*','product_category.category_name')->orderBy('nama_produk', 'asc')->get();
        return ProdukResource::collection($allProduk);
    }

    public function getStockById()
    {
        $stock = Produk::find(request()->id);
        return $stock->stok;
    }

    public function delete()
    {
        $status = 'success';
        $msg = 'Produk berhasil dihapus';
        try{
            $data = Produk::where('id', request()->id)->delete();
        }catch(Exception $e){
            report($e);
            $status = 'error';
            $msg = 'Produk Gagal dihapus';
            $data = $e;
        }
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    public function update(Request $req)
    {
        $status = 'success';
        $msg = 'Produk '.$req->nama_produk.' berhasil diupdate';

        try{
            DB::beginTransaction();
            $produk = Produk::find($req->id);
        
            //Jika ada perubahan harga, update history produk
            if($produk->harga_modal != $req->harga_modal || $produk->harga_jual != $req->harga_jual){
                $hist_produk = new HistoryProduk;
                $hist_produk->id_produk = $req->id;
                $hist_produk->harga_modal_before = $produk->harga_modal;
                $hist_produk->harga_jual_before = $produk->harga_jual;
                $hist_produk->harga_modal_after = $req->harga_modal;
                $hist_produk->harga_jual_after = $req->harga_jual;
                $hist_produk->user = Auth::user()->email;
                $hist_produk->save();
            }

            // Update Produk
            $produk->nama_produk = $req->nama_produk;
            $produk->id_kategori = $req->id_kategori;
            $produk->harga_modal = $req->harga_modal;
            $produk->harga_jual = $req->harga_jual;
            $produk->diskon = $req->diskon;
            $produk->distributor = $req->distributor;
            $produk->deskripsi = $req->deskripsi;
            $produk->status = $req->status;
            $produk->save();

            $data = $produk;
            DB::commit();
        }catch(Exception $e){
                DB::rollback();
            $status = 'error';
            $msg = 'Produk Gagal diupdate';
            $data = $e;
        }
        
        // RETURN
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    public function stockIn(){
        return view("stock.in");
    }

    public function stockOut(){
        return view("stock.out");
    }

    public function addStock()
    {
        if(request()->tambah_stok < 1){
            return response()->json([
                'status' => 'error',
                'msg' => 'Tambah stok harus lebih dari 0'
            ]);
        }

        $status = 'success';
        $message = 'Stok berhasil ditambah';
        try{
            $produk = Produk::find(request()->id_produk);

            $before = $produk->stok;
            $add_stok = request()->tambah_stok;
            $after = $before + $add_stok;

            $hist_stok = new HistoryStok;
            $hist_stok->id_produk = request()->id_produk;
            $hist_stok->description = request()->description;
            $hist_stok->before = $before;
            $hist_stok->add_stok = $add_stok;
            $hist_stok->after = $after;
            $hist_stok->user = Auth::user()->email;

            $produk->stok = $after;

            $produk->save();
            $hist_stok->save();
            $data = $hist_stok;
        }catch(Exception $e){
            report($e);
            $status = 'error';
            $message = 'Stok Gagal tersimpan';
            $data = $e;
        }
    
        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);

    }

    public function outStock()
    {
        if(request()->stock_out < 1){
            return response()->json([
                'status' => 'error',
                'msg' => 'Out stok harus lebih dari 0'
            ]);
        }

        $status = 'success';
        $message = 'Stok berhasil dikurangi';
        try{
            $produk = Produk::find(request()->id_produk);

            $before = $produk->stok;
            $add_stok = request()->stock_out;
            $after = $before - $add_stok;

            $hist_stok = new HistoryStok;
            $hist_stok->id_produk = request()->id_produk;
            $hist_stok->description = request()->description;
            $hist_stok->before = $before;
            $hist_stok->add_stok = $add_stok;
            $hist_stok->after = $after;
            $hist_stok->user = Auth::user()->email;

            $produk->stok = $after;

            $produk->save();
            $hist_stok->save();
            $data = $hist_stok;
        }catch(Exception $e){
            report($e);
            $status = 'error';
            $message = 'Stok Gagal tersimpan';
            $data = $e;
        }
    
        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ]);

    }

    public function getHistoryStokInByDate(){
        $end = date('Y-m-d', strtotime(request()->end. ' + 1 days'));
        $hist = DB::select("
        SELECT A.*, B.nama_produk 
        FROM history_stok A
        INNER JOIN produk B ON A.id_produk = B.id
        WHERE A.before < A.after 
        AND A.created_at BETWEEN ? AND ?
        ORDER BY A.id DESC
        
        ", [request()->start,$end]);
        
        return HistoryStokResource::collection($hist);
    }

    public function getHistoryStokOutByDate(){
        $end = date('Y-m-d', strtotime(request()->end. ' + 1 days'));
        $hist = DB::select("
        SELECT A.*, B.nama_produk 
        FROM history_stok A
        INNER JOIN produk B ON A.id_produk = B.id
        WHERE A.before > A.after 
        AND A.created_at BETWEEN ? AND ?
        ORDER BY A.id DESC
        
        ", [request()->start,$end]);
        
        return HistoryStokResource::collection($hist);
    }

    public function getProductByCode($code)
    {
        $product = DB::table('detail_produk')
            ->join('produk', 'detail_produk.id_produk', '=', 'produk.id')
            ->select('produk.id', 'produk.nama_produk', 'produk.harga_jual', 'produk.stok')
            ->where('detail_produk.kode_produk', $code)
            ->first();

        return response()->json([$product]);
    }

    //HISTORY PRODUK
    public function historyProduk()
    {
        return view("produk.history");
    }

    public function getAllHistory()
    {
        return HistoryProdukResource::collection(HistoryProduk::join('produk','produk.id','=','history_produk.id_produk')
                                                            ->get(['history_produk.*','produk.nama_produk'])
        );
    }

    public function updateStokWajar()
    {
        $stok_wajar = DB::select("
        SELECT Z.id,CEIL(Z.avg_sell_permonth/10) AS warning_stok, CEIL(Z.avg_sell_permonth/2) AS stok_wajar FROM (
            SELECT A.id, A.nama_produk,A.distributor,A.stok, (
                SELECT COALESCE(SUM(B.jumlah),0) FROM detail_transaksi B 
                WHERE A.id = B.id_produk AND B.id_trx_category=1 AND B.created_at > ?) AS avg_sell_permonth 
            FROM produk A WHERE A.status=1
            ) Z
        WHERE Z.stok < 500
        ", [Carbon::now()->subDays(30)]);
        DB::beginTransaction();
        foreach ($stok_wajar as $data) {
            try{
                $produk = Produk::find($data->id);
                $produk->warning_stok = $data->warning_stok;
                $produk->stok_wajar = $data->stok_wajar;
                $produk->save();
            }catch(Exception $e){
                DB::rollback();
                report($e);
                return $e;
            }
        }
        DB::commit();
    }
}
