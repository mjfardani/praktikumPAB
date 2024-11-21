@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('Bayar') }}</h1>
    <div class="card mb-3 w-100">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="{{ url('/produk.jpg') }}"
                    class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h2 class="card-title">{{ $transaksi->produk->nama_produk}}</h2>
                </div>
                <form action="{{ url('/transaksi/simpan_ongkir') }}" method="post">
                    @csrf

                    <input type="hidden" name="id" value="{{ $transaksi->id }}" />

                    <input type="hidden" name="weight"
                        value="{{ $transaksi->weight }}" />
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Rasa:
                            {{ $transaksi->produk->rasa }}
                        </li>
                        <li class="list-group-item">Berat Satuan:
                            {{ $transaksi->produk->berat}}gr
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">

                                    <label class="col-form-label" for="qty">Qty:</label>
                                </div>

                                <div class="col-6">

                                    <input type="text" name="qty" class="form-control"
                                        value="{{ $transaksi->qty }}" readonly />
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                    <label class="col-form-label"
                                        for="courier">Kurir:</label>
                                </div>

                                <div class="col-6">

                                    <input type="text" class="form-control"
                                        value="{{ strtoupper($transaksi->courier) }}"
                                        readonly />
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                    <label class="col-form-label"
                                        for="service">Service:</label>
                                </div>

                                <div class="col-6">

                                    <input type="text" class="form-control"
                                        value="{{ $transaksi->service }}" readonly />
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6 text-start">
                                    <label class="col-form-label" for="harga_barang">
                                        Harga Barang:</label>
                                </div>

                                <div class="col-6 text-end">

                                    <input type="text" id="harga_barang"
                                        name="harga_barang" class="form-control"
                                        value="{{ $transaksi->harga_barang }}" readonly />
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6 text-start">
                                    <label class="col-form-label"
                                        for="ongkos_kirim">Ongkos Kirim:</label>
                                </div>

                                <div class="col-6 text-end">

                                    <input type="text" name="ongkos_kirim"
                                        class="form-control"
                                        value="{{ $transaksi->ongkos_kirim }}" readonly />
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="row">

                                <div class="col-6 text-start">
                                    <label class="col-form-label"
                                        for="total_harga">Total Harga:</label>
                                </div>

                                <div class="col-6 text-end">

                                    <input type="text" id="total_harga" name="total_harga"
                                        class="form-control"
                                        value="{{ $transaksi->total_harga }}"
                                        readonly />
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item text-end">

                            <button class="btn btn-primary" type="button"
                                onclick="bayar()">BAYAR</button>&nbsp;
                            <a href="{{ url('/home') }}" c
                                lass="btn">KEMBALI</a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>
<script>
    function bayar() {
        snap.pay('{{ $token }}', {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
                console.log(result)
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                console.log(result)
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                console.log(result)
            }
        });
    }
</script>
@endsection