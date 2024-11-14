<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'KONSUMEN') {
            $alamat = Alamat::where('user_id', Auth::user()->id)->first();
            $last_produk = Produk::orderBy('id', 'desc')->first();
            return view('home.konsumenindex', [
                'alamat' => $alamat,
                'last_produk' => $last_produk
            ]);
        }
        return view('home');
    }
}