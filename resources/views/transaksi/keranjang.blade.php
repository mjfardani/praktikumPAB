@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('Keranjang') }}</h1>
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
                <form action="{{ url('/transaksi/checkout') }}" method="post">
                    @csrf
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Rasa:
                            {{ $transaksi->produk->rasa }}
                        </li>
                        <li class="list-group-item">Ukuran:
                            {{ $transaksi->produk->ukuran }}ml
                        </li>
                        <li class="list-group-item">Berat Satuan:
                            {{ $transaksi->produk->berat}}gr
                        </li>
                        <li class="list-group-item">Harga Satuan:
                            {{ $transaksi->produk->harga}}
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                    <label class="col-form-label" for="qty">Qty:</label>
                                </div>

                                <div class="col-6">

                                    <input type="hidden" name="produk_id"
                                        value="{{ $transaksi->produk->id }}" />
                                    <input type="hidden" name="berat_satuan"
                                        value="{{ $transaksi->produk->berat }}" />
                                    <select class="form-control" name="qty">
                                        @for ($i=1;$i<=10;$i++)
                                            <option value="{{ $i }}"

                                            {{ $transaksi->qty == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                            </option>
                                            @endfor
                                    </select>

                                </div>
                            </div>
                        </li>

                        <li class="list-group-item text-end">

                            <button class="btn btn-primary" type="button"
                                onclick="keranjang()">KERANJANG</button>&nbsp;
                            <button class="btn btn-primary" onclick="checkout()">CHECK OUT</button>
                            &nbsp;
                            <button class="btn btn-danger" type="button"
                                onclick="batal()">BATAL</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function keranjang() {
        const form = document.createElement('form');
        form.method = 'post';
        form.action = '{{ url("/transaksi/tambah_keranjang") }}';
        const produkField = document.createElement('input');
        produkField.type = 'hidden';
        produkField.name = 'produk_id';
        produkField.value = '{{ $transaksi->produk_id }}';
        form.appendChild(produkField);
        const qtyField = document.createElement('input');
        qtyField.type = 'hidden';
        qtyField.name = 'qty';
        qtyField.value = document.getElementsByName("qty")[0].value;
        form.appendChild(qtyField);
        const tokenField = document.createElement('input');
        tokenField.type = 'hidden';
        tokenField.name = '_token';
        tokenField.value = document
            .querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(tokenField);
        document.body.appendChild(form);
        form.submit();
    }

    function batal() {
        if (confirm('Yakin batal keranjang?')) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = '{{ url("/transaksi/hapus_keranjang") }}';
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = document
                .querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(tokenField);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function checkout() {
        const form = document.createElement('form');
        form.method = 'post';
        form.action = '{{ url("/transaksi/checkout") }}';
        const tokenField = document.createElement('input');
        tokenField.type = 'hidden';
        tokenField.name = '_token';
        tokenField.value = document
            .querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(tokenField);
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection