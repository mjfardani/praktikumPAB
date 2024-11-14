@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('Alamat') }}</h1>
    <div class="row mb-3">
        <label for="alamat" class="col-3 col-form-label">Alamat</label>
        <div class="col-9">
            <input type="text" class="form-control" id="alamat"
                name="alamat" value="{{ $alamat->alamat }}"
                readonly="readonly" />
        </div>
    </div>
    <div class="row mb-3">
        <label for="province_id" class="col-3 col-form-label">Provinsi</label>
        <div class="col-9">
            <input type="text" class="form-control" id="province_id"
                name="province_id" value="{{ $alamat->city->province }}"
                readonly="readonly" />
        </div>
    </div>
    <div class="row mb-3">
        <label for="kota_id" class="col-3 col-form-label">Kota</label>
        <div class="col-9">
            <input type="text" class="form-control" id="kota_id"
                name="kota_id"
                value="{{ $alamat->city->type.' '.$alamat->city->city_name }}"
                readonly="readonly" />
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('/home') }}" class="btn btn-large btn-primary">
                Tutup
            </a>
            <a href="{{ url('/alamat/edit/0') }}"
                class="btn btn-large btn-secondary">
                Ubah
            </a>
        </div>
    </div>
    </form>
</div>
@endsection