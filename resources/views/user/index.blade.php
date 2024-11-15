@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ __('User') }}</h1>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-large btn-primary"
                href="{{ url('/user/create') }}">Tambah User</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Email</th>
                <th>Nama Lengkap</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td class="d-flex">
                    <a href="{{ url('/user/edit/'.$user->id) }}"
                        class="btn btn-primary">Edit
                    </a>
                    &nbsp;
                    <form action="{{ url('/user/destroy/'.$user->id) }}"
                        method="POST">
                        @csrf

                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->role }}</td>
            </tr>

            @empty
            <tr>
                <td colspan="4">
                    <div class="alert alert-warning"> Tidak ada data!</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($user)
    @endif
</div>
@endsection