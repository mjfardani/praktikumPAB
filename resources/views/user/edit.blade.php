@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('User') }}</h1>
    <form method="post" action="{{ url('/user/update/'.$user->id) }}">
        @csrf
        <div class="row mb-3">
            <label for="email" class="col-3 col-form-label">Email</label>
            <div class="col-9">
                <input type="text" readonly class="form-control-plaintext" id="email"
                    name="email" value="{{ $user->email }}" />
            </div>
        </div>
        <div class="row mb-3">

            <label for="name" class="col-3 col-form-label">Nama Lengkap</label>
            <div class="col-9">
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name') ?? $user->name }}" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="role" class="col-3 col-form-label">Role</label>
            <div class="col-9">
                <select class="form-control" name="role">
                    <option {{ (old('role') ?? $user->role) == 'KONSUMEN' ?
'SELECTED' : '' }}

                        value="KONSUMEN">KONSUMEN</option>

                    <option {{ (old('role') ?? $user->role) == 'TOKO' ?
'SELECTED' : '' }}
                        value="TOKO">TOKO</option>
                </select>
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