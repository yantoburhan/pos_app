@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-6">
        <h2> Tambah Supplier</h2>
        <p class="text-muted">Tambahkan Supplier.</p>
    </div>
    <div class="col-6">

        <div class="card">
            <div class="card-body">
        <!-- Form Create User -->
                <form action="{{route ('suppliers.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Input Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Supplier</label>
                        <input value="{{old('name')}}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Inpout No Telepon --}}
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input value="{{old('phone')}}" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                        @error('phone')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Input No Fax --}}
                    <div class="mb-3">
                        <label for="fax" class="form-label">Nomor Fax</label>
                        <input value="{{old('fax')}}" type="number" class="form-control @error('fax') is-invalid @enderror" id="fax" name="fax">
                        @error('fax')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Input Alamat --}}
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea name="address" id="address" rows="5" class="form-control @error('address') is-invalid @enderror">{{old('address')}}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Tombol Submit --}}
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
