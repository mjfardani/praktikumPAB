@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('Alamat') }}</h1>
    <form method="post" action="{{ url('/alamat/update/'.$alamat->id) }}">
        @csrf
        <div class="row mb-3">
            <label for="alamat" class="col-3 col-form-label">Alamat</label>
            <div class="col-9">
                <input type="text" class="form-control" id="alamat"
                    name="alamat" value="{{ old('alamat', $alamat->alamat) }}" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="province_id" class="col-3 col-form-label">Provinsi</label>
            <div class="col-9">
                <select class="form-select" name="province_id"
                    onchange="province_change(this)">
                    @foreach ($provinces as $province)
                    <option value="{{ $province->province_id }}"

                        @selected(old('province_id', $alamat->province_id)==
                        $province->province_id)>{{ $province->province }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="kota_id" class="col-3 col-form-label">Kota</label>
            <div class="col-9">
                <select class="form-select" name="kota_id">
                    @foreach ($cities as $city)
                    <option value="{{ $city->city_id }}"
                        @selected(old('kota_id', $alamat->kota_id)==
                        $city->city_id)>{{ $city->type.' '.$city->city_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-large btn-primary">
                    Simpan
                </button>
                <a href="{{ Auth::user()->role=='KONSUMEN' ? url('/home') :
url('/alamat') }}" class="btn btn-large btn-secondary">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
<script>
    function province_change(obj) {
        let url = '{{ url("/api/city") }}' + '?province_id=' + obj.value;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", url);
        xhr.send();
        xhr.responseType = "json";
        xhr.onload = () => {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let objCity = document.getElementsByName("kota_id")[0];
                objCity.options.length = 0;
                for (var i = 0; i < xhr.response.length; i++) {
                    var city = xhr.response[i];
                    objCity.append(new Option(city.type + ' ' + city.city_name,
                        city.city_id, i == 0 ? true : false, false));
                }
            } else {

                console.log(`Error: ${xhr.status}`);
            }
        };
    }
</script>
@endsection