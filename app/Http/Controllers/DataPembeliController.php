<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class DataPembeliController extends Controller
{
    //
    public function store(Request $request){

        $nik = $request->ktp;
        // return $nik;
        $nama = $request->nama;
        // return $nama;
        $curl = curl_init();
 
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.binderbyte.com/cekktp?nik=$nik&nama=$nama&api_key=1e643c3f336aea4fb13a1e56185e6e6e3909e8cfeeb203880efb704167405170",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type:application/json',
                ),
            ));
 
        $response = curl_exec($curl);
        $err = curl_error($curl);
 
        curl_close($curl);
 
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $sel = json_decode($response);
                    // dd($kota);
        }
        
        try {
            //code...
            
            $nama = $sel->data->nama;
            $namaPropinsi = $sel->data->namaPropinsi;
            $namaKabko = $sel->data->namaKabko;
            $namaKec = $sel->data->namaKec;
            $namaKel = $sel->data->namaKel;
            $salamat = $namaPropinsi.','.$namaKabko.','.$namaKec.','.$namaKel;
            
            $list = new \App\Listing;
            $list->nik = $request->ktp;
            $list->nama = $nama;
            $list->alamat = $salamat;
            $list->status=0;
            $list->save();
            
            Session::flash('sukses','Berhasil di simpan : Periksa Keranjang');
            return redirect()->back();
        } catch (\Throwable $th) {
            if ($sel->message == "failed") {
                Session::flash('error',$sel->data->pesan);
                return redirect()->back();
            }
        }
    }
}
