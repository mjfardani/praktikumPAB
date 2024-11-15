<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function daftar_produk()
    {
        if (
            Transaksi::where('status_transaksi', 'PESAN')
            ->where('user_id', Auth::user()->id)
            ->first() != null
        ) return redirect('/transaksi/keranjang');
        $produks = Produk::paginate(4);
        return view('transaksi.daftar_produk', ['produks' => $produks]);
    }
    public function tambah_keranjang(Request $request)
    {
        $request->validate([
            'qty' => 'required|integer',
            'produk_id' => 'required|exists:produks,id',
        ]);
        $keranjang = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '')->where('user_id', Auth::user()->id)->first();
        $checkedOut = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '<>', '')
            ->where('user_id', Auth::user()->id)->first();
        if ($checkedOut != null) return redirect('/home');
        if ($keranjang != null) {
            if ($keranjang->produk_id != $request->produk_id) {
                return redirect('/transaksi/keranjang');
            }
        }
        if ($keranjang == null) {
            $keranjang = new Transaksi();
            $keranjang->tanggal_order = Carbon::today();
            $keranjang->user_id = Auth::user()->id;
            $alamat = Alamat::where('user_id', $keranjang->user_id)->first();
            $keranjang->alamat_id = $alamat->id;
            $keranjang->produk_id = $request->produk_id;
            $keranjang->qty = $request->qty;
            $keranjang->status_transaksi = 'PESAN';
            $keranjang->rating = 1;
            $keranjang->courier = '';
            $keranjang->service = '';
            $keranjang->waktu_kirim = 0;
            $keranjang->ongkos_kirim = 0;
            $keranjang->total_harga = 0;
        } else {
            $keranjang->qty = $request->qty;
        }
        $produk = Produk::find($request->produk_id);
        $keranjang->harga_barang = $produk->harga * $keranjang->qty;
        $berat_kirim = $this->hitung_berat_kirim($keranjang->qty, $produk->berat);
        $keranjang->weight = $berat_kirim;
        $keranjang->save();
        return redirect('/transaksi/keranjang');
    }

    public function hapus_keranjang(Request $request)
    {
        $keranjang = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '')->where('user_id', Auth::user()->id)->first();
        $checkedOut = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '<>', '')->where('user_id', Auth::user()->id)->first();
        if ($checkedOut != null) return redirect('/home');
        if ($keranjang != null) {
            $keranjang->delete();
        }
        return redirect('/home');
    }
    public function hitung_berat_kirim($qty, $berat)
    {
        $berat_wadah = 50;
        return ceil((($qty * ($berat + $berat_wadah))) / 1000.0) * 1000;
    }
    public function keranjang()
    {
        $keranjang = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '')->where('user_id', Auth::user()->id)->first();
        $checkedOut = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '<>', '')->where('user_id', Auth::user()->id)->first();
        if ($checkedOut != null) return redirect('/home');
        if ($keranjang == null) return redirect('/transaksi/daftar_produk');
        return view('transaksi.keranjang', ['transaksi' => $keranjang]);
    }
}
