<?php

namespace App\Http\Controllers;

use App\Finance;
use App\PPOB;
use App\PpobProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function GuzzleHttp\json_decode;

class PPOBController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'Authorization' => '6e22d1812c58ab0cd2ad08ecca4867c2',
            'Accept' => 'Application/json',
        ])->get('https://api.serpul.co.id/prabayar/category');

        $md5 = md5("rakarogdjwZDdev-4fd5e770-7849-11eb-bb39-970002fd1cd6pricelist");
        return view('ppob.index',compact('response','md5'));
    }

    public function getOperator()
    {
        $response = Http::withHeaders([
            'Authorization' => '6e22d1812c58ab0cd2ad08ecca4867c2',
            'Accept' => 'Application/json',
        ])->get('https://api.serpul.co.id/prabayar/operator?product_id='.request()->category_id);
        return $response->json();
    }

    public function getProduct()
    {
        $response = Http::withHeaders([
            'Authorization' => '6e22d1812c58ab0cd2ad08ecca4867c2',
            'Accept' => 'Application/json',
        ])->get('https://api.serpul.co.id/prabayar/product?product_id='.request()->operator_id);
        return $response->json();
    }

    public function send(Request $req)
    {
        $response = Http::withHeaders([
            'Authorization' => '6e22d1812c58ab0cd2ad08ecca4867c2',
            'Accept' => 'Application/json',
        ])->get('https://api.serpul.co.id/prabayar/product?product_id='.$operator_id);

        $res = json_decode($response, true);
        if($res['responseCode'] == 200){
            $data = $res['responseData'];
            foreach($data as $d){
                $price = $d['product_price'] + ($d['product_price'] * (2/100));
                $ceil = ceil($price/100);
                $product_price_sell = $ceil*100;
                $d['product_price_sell'] = $product_price_sell;
                PpobProduct::create(
                    $d
                );
            }
        }

        // $PpobProduct = PpobProduct::create();
        // $PpobProduct = PpobProduct::where('product_id',$req->product_id)->first();
        // $saldoPpob = Finance::get('ppob')->first();
        // if($saldoPpob < $PpobProduct->product_price_sell){
        //     return "SALDO TIDAK CUKUP";
        // }
        
        // DB::beginTransaction();
        // PPOB::create([
        //     'product_id' => $req->product_id,
        //     'message' => 'Sedang diproses',
        //     'status' => 0,
        // ]);

        // $response = Http::withHeaders([
        //     'Authorization' => '6e22d1812c58ab0cd2ad08ecca4867c2',
        //     'Accept' => 'Application/json',
        // ])->post('https://api.serpul.co.id/prabayar/order',$req->all());

        // $res = json_decode($response, true);
        // if($res['responseCode'] == 400){
        //     return "NISA";
        // }

        return $res;
    }

    public function createAllProduct()
    {
        $response = Http::withHeaders([
            'Authorization' => '6e22d1812c58ab0cd2ad08ecca4867c2',
            'Accept' => 'Application/json',
        ])->get('https://api.serpul.co.id/prabayar/product?product_id='.$operator_id);

        $res = json_decode($response, true);
        if($res['responseCode'] == 200){
            $data = $res['responseData'];
            foreach($data as $d){
                $price = $d['product_price'] + ($d['product_price'] * (2/100));
                $ceil = ceil($price/100);
                $product_price_sell = $ceil*100;
                $d['product_price_sell'] = $product_price_sell;
                PpobProduct::create(
                    $d
                );
            }
        }

        

        return $res;
    }
}
