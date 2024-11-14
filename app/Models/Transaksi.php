<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Alamat;
use App\Models\Produk;

class Transaksi extends Model
{
use HasFactory;
protected $fillable = [
'tanggal_order',
'tanggal_bayar',
'user_id',
'alamat_id',

'produk_id',
'qty',
'weight',
'courier',
'service',
'waktu_kirim',
'ongkos_kirim',
'harga_barang',
'total_harga',
'status_transaksi',
'tanggal_terima',
'rating',
];
public function user(){
return $this->hasOne(User::class, 'id', 'user_id');
}
public function alamat(){
return $this->hasOne(Alamat::class, 'id', 'alamat_id');
}
public function produk(){
return $this->hasOne(Produk::class, 'id', 'produk_id');
}
}
