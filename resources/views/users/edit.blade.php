@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-6">
        <h2> Uah Data User</h2>
        <p class="text-muted">Perbarui data akun {{$user->name}}.</p>
    </div>
    <div class="col-6">

        <div class="card">
            <div class="card-body">
        <!-- Form Edit User -->
                <form action="{{route ('users.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- Id user di dalam hidden input --}}
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <!-- Input Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input value="{{old('name', $user->name)}}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!-- Input Email -->
                    <div class="mb-3">
                        <label for="email">Alamat Email</label>
                        <input value="{{old('email', $user->email)}}" type="email" name="email" id="email" class="form-control @error('email') is-invalid
                        @enderror">
                        @error('email')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!-- Input Username -->
                    <div class="mb-3">
                        <label for="username">Login Username</label>
                        <input value="{{old('username', $user->username)}}" type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror">
                        @error('username')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!-- Input Telepon -->
                    <div class="mb-3">
                        <label for="telepon">Nomor Telepon</label>
                        <input value="{{old('phone', $user->phone)}}" type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!-- Input Role -->
                    <div class="mb-3">
                        <label for="role">Jabatan</label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                            <option value="">Pilih salah satu</option>
                            <option value="1" {{old('role', $user->role) == 1 ? 'selected' : ''}}>Admin</option>
                            <option value="2" @if(old('role', $user->role) == 2) selected @endif>Kasir</option>
                            @error('role')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </select>
                    </div>
                    <!-- Input Foto -->
                    <div class="mb-3">
                        <label for="photo_path">Foto Profil</label>
                        <input value="{{old('photo_path', $user->photo_path)}}" type="file" name="photo_path" id="photo_path" class="form-control @error('photo_path') is-invalid @enderror">
                        @error('photo_path')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!-- Input Submit -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
