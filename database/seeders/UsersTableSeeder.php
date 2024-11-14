<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
DB::table('users')->insert([
'name' => 'Administrator Toko',
'email' => 'admin@tokoku.com',
'email_verified_at' => now(),
'password' => bcrypt('12345678'),
'remember_token' => Str::random(10),
'role' => 'TOKO',
]);
}
}
