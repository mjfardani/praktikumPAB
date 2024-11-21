<?php

namespace App\Http\Controllers;

use App\Libs;
use App\Models\Alamat;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Midtrans\CreateSnapTokenService;

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
    public function checkout()
    {
        $keranjang = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '')->where('user_id', Auth::user()->id)->first();
        $unpaid = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '<>', '')->where('user_id', Auth::user()->id)->first();
        if ($unpaid != null) return redirect('/transaksi/bayar');
        if ($keranjang == null) return redirect('/transaksi/daftar_produk');
        $keranjang->courier = 'pos';
        $alamat = Alamat::find($keranjang->alamat_id);
        $raja_ongkir = Libs::hitung_ongkos_kirim(
            $keranjang->weight,
            env('RAJAONGKIR_ORIGIN'),
            $alamat->kota_id,
            $keranjang->courier
        );
        if ($raja_ongkir['code'] == '200') {
            $services = $raja_ongkir['services'];
            $pilihan = $services[0];
            $keranjang->service = $pilihan['service'];
            $keranjang->ongkos_kirim = $pilihan['ongkos_kirim'];
            $keranjang->total_harga = $keranjang->harga_barang + $keranjang->ongkos_kirim;
        }
        return view('transaksi.checkout', [
            'transaksi' => $keranjang,
            'destination' => $alamat->kota_id,
            'couriers' => ['jne', 'pos', 'tiki'],
            'services' => $services
        ]);
    }
    public function simpan_ongkir(Request $request)
    {
        $request->validate([
            'service' => 'required',
            'courier' => 'required',
            'ongkos_kirim' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);
        $transaksi = Transaksi::find($request->id);
        $transaksi->service = $request->service;
        $transaksi->courier = $request->courier;
        $transaksi->ongkos_kirim = $request->ongkos_kirim;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->save();
        return redirect('/transaksi/bayar');
    }
    public function bayar()
    {
        $keranjang = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '')->where('user_id', Auth::user()->id)->first();
        $unpaid = Transaksi::where('status_transaksi', 'PESAN')
            ->where('courier', '<>', '')->where('user_id', Auth::user()->id)->first();
        if ($keranjang != null) return redirect('/transaksi/keranjang');
        if ($keranjang == null && $unpaid == null) return redirect('/home');
        $service = new CreateSnapTokenService($unpaid);
        $token = $service->getSnapToken();
        return view('transaksi.bayar', ['transaksi' => $unpaid, 'token' => $token]);
    }
}
