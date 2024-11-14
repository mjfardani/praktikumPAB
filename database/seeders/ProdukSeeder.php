<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produks')->insert([
            'nama_produk' => 'Almond Premium 250gr',
            'berat' => 250,
            'rasa' => 'Original',
            'harga' => 50000,
            'image_url' => '-',
        ]);
        DB::table('produks')->insert([
            'nama_produk' => 'Almond Premium 500gr',
            'berat' => 500,
            'rasa' => 'Original',
            'harga' => 95000,
            'image_url' => '-',
        ]);
        DB::table('produks')->insert([
            'nama_produk' => 'Almond Premium 1KG',
            'berat' => 1000,
            'rasa' => 'Original',
            'harga' => 190000,
            'image_url' => '-',
        ]);
    }
}
