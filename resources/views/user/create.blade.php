@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('User') }}</h1>
    <form method="post" action="{{ url('/user/store') }}">
        @csrf
        <div class="row mb-3">
            <label for="email" class="col-3 col-form-label">Email</label>
            <div class="col-9">
                <input type="text" class="form-control" id="email" name="email"
                    value="{{ old('email') }}" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="name" class="col-3 col-form-label">Nama Lengkap</label>
            <div class="col-9">
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name') }}" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="role" class="col-3 col-form-label">Role</label>
            <div class="col-9">
                <select class="form-control" name="role">
                    <option {{ (old('role')) == 'KONSUMEN' ? 'SELECTED' : '' }}
                        value="KONSUMEN">KONSUMEN</option>
                    <option {{ (old('role')) == 'TOKO' ? 'SELECTED' : '' }}
                        value="TOKO">TOKO</option>
                </select>

            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-3 col-form-label">Password</label>
            <div class="col-9">
                <input type="password" class="form-control" name="password" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="password_confirmation" class="col-3 col-form-label">
                Password Confirmation</label>
            <div class="col-9">
                <input type="password" class="form-control"
                    name="password_confirmation" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-large btn-primary">
                    Simpan
                </button>
                <a href="{{ url('/user') }}" class="btn btn-large btn-secondary">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection