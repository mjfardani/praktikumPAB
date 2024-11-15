@extends('layouts.app')
@section('content')
<style>
    .carousel-caption {
        color: #000;
        background: rgba(255, 255, 255, 0.5)
    }
</style>
<div class="container">
    @if($alamat==null)
    <div class="card text-bg-warning mb-3 text-center" style="width:100%">
        <div class="card-body">
            <h2 class="card-title">Alamat</h2>
            <p class="card-text">Anda belum mendaftarkan alamat pengiriman.
                Harap daftarkan alamat pengiriman agar anda dapat melakukan
                transaksi</p>
            <a href="{{ url('/alamat/create') }}" class="btn btn-primary">
                Daftarkan alamat</a>
        </div>
    </div>
    @endif

    <div id="tokokuCarousel" class="carousel slide carousel-fade" data-bs-ride="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#tokokuCarousel" data-bs-slide-to="0"
                class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#tokokuCarousel" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ url('/banner.png') }}"
                    style="height:400px;object-fit:cover" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Selamat datang di tOkokU</h5>
                    <p>
                        @if($alamat==null)

                        Hanya produk terbaik untuk anda!
                        @else
                        Mulai transaksi <a href="{{ url('/transaksi/daftar_produk') }}">di sini</a>
                        @if($keranjang!=null)
                    <div class="card text-bg-warning mb-3 text-center" style="width:100%">
                        <div class="card-body">
                            <h2 class="card-title">Keranjang</h2>
                            <p class="card-text">Selesaikan belanjamu</p>
                            <a href="{{ url('/transaksi/keranjang') }}" class="btn btn-primary">
                                Lihat keranjang</a>
                        </div>
                    </div>
                    @endif
                    @endif
                    </p>
                </div>
            </div>
            @if($last_produk)
            <div class="carousel-item">
                <img src="{{ url('/produk.jpg') }}"
                    style="height:400px;object-fit:cover" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $last_produk->nama_produk }}</h5>
                    <p>
                        @if($alamat==null)

                        Hanya produk terbaik untuk anda!
                        @else
                        Mulai transaksi <a href="#">di sini</a>

                        @endif
                    </p>
                </div>
            </div>
            @endif
        </div>
        <button class="carousel-control-prev" type="button"
            data-bs-target="#tokokuCarousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button"
            data-bs-target="#tokokuCarousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    @endsection