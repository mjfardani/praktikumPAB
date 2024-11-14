<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('tanggal_order');
            $table->dateTime('tanggal_bayar')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('alamat_id');
            $table->bigInteger('produk_id');
            $table->integer('qty');
            $table->integer('weight');
            $table->string('courier');
            $table->string('service');
            $table->integer('waktu_kirim');
            $table->integer('ongkos_kirim');
            $table->integer('harga_barang');
            $table->integer('total_harga');
            $table->enum('status_transaksi',['PESAN', 'TERBAYAR', 'SELESAI'])
            ->default('PESAN');
            $table->dateTime('tanggal_terima')->nullable();
            $table->integer('rating')->default(0);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
