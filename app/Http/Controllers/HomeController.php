<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Terjual;
use App\BarangIn;
use DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __construct(){
        $this->middleware('admin');
    }
    public function index()
    {
        $jumlah_pendapatan=DB::table('terjuals')->sum('total_harga');
        $jumlah_pengeluaran=DB::table('barang_ins')->sum('total_harga');
        $jumlah_transaksi=DB::table('terjuals')->count();
        $jumlah_barang=DB::table('barang')->count();
        $jumlah_barang_masuk = DB::table('barang_ins')->count();
        $margin = $jumlah_pendapatan - $jumlah_pengeluaran;

        
         return view('home',compact('jumlah_pendapatan','jumlah_transaksi','jumlah_barang','jumlah_barang_masuk','jumlah_pengeluaran','margin'));
    }
}
