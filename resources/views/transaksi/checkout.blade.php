@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('Checkout') }}</h1>
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

                                    <select class="form-control" name="courier"
                                        aria-label="courier" onchange="hitung()">
                                        @foreach ($couriers as $courier)
                                        <option value="{{ $courier }}"

                                            {{ $courier==$transaksi->courier ? 'SELECTED' : '' }}>
                                            {{ strtoupper($courier) }}
                                        </option>
                                        @endforeach
                                    </select>
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

                                    <select class="form-control" name="service"
                                        aria-label="service" onchange="hitung()">
                                        @foreach ($services as $service)
                                        <option value="{{ $service['service'] }}"
                                            {{ $service==$transaksi->service ?
'SELECTED' : '' }}>
                                            {{ $service['service'] }}
                                        </option>
                                        @endforeach
                                    </select>
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

                            <button class="btn btn-primary">BAYAR</button>&nbsp;
                            <a href="{{ url('/home') }}" c
                                lass="btn">KEMBALI</a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function hitung() {
        var harga_barang = document.getElementsByName("harga_barang")[0].value;
        var courier = document.getElementsByName("courier")[0].value;
        var weight = document.getElementsByName("weight")[0].value;
        const url = '{{ url("/api/get_ongkir") }}';
        const params = 'destination=' + {
                {
                    $destination
                }
            } +
            '&weight=' + weight + '&courier=' + courier;
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.withCredentials = true;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    var services = response['services'];
                    var cservice = document.getElementsByName("service")[0].value;
                    var found = false;
                    var ongkos_kirim = 0;
                    for (var i = 0; i < services.length; i++) {
                        if (cservice == services[i]['service']) {
                            found = true;
                            console.log(services[i]['ongkos_kirim']);
                            ongkos_kirim = services[i]['ongkos_kirim'];
                        }
                    }

                    if (found == false) {
                        console.log('false');
                        ongkos_kirim = services[0]['ongkos_kirim'];
                        // waktu_kirim = services[0]['waktu_kirim'];

                        document.getElementsByName("service")[0].options.length = 0;

                        for (var i = 0; i < services.length; i++) {
                            document.getElementsByName("service")[0]
                                .add(new Option(services[i]['service'],
                                    services[i]['service']));
                        }
                    }
                    document.getElementsByName("ongkos_kirim")[0].value = ongkos_kirim;
                    document.getElementsByName("total_harga")[0].value =
                        Number(document.getElementsByName("harga_barang")[0].value) +
                        Number(ongkos_kirim);
                } else {
                    console.error('Error:', xhr.statusText);
                }
            }
        };
        xhr.onerror = function() {
            console.error('Request error');
        };
        xhr.send(params);
    }
</script>
@endsection