@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-6">
        <h2> Ubah Supplier {{$supplier->name}}</h2>
        <p class="text-muted">Ubah data {{$supplier->name}}.</p>
    </div>
    <div class="col-6">

        <div class="card">
            <div class="card-body">
        <!-- Form Create User -->
                <form action="{{route ('suppliers.update', $supplier->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Input Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Supplier</label>
                        <input value="{{old('name', $supplier->name)}}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Input No Telepon --}}
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input value="{{old('phone', $supplier->phone)}}" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                        @error('phone')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Input No Fax --}}
                    <div class="mb-3">
                        <label for="fax" class="form-label">Nomor Fax</label>
                        <input value="{{old('fax', $supplier->fax)}}" type="number" class="form-control @error('fax') is-invalid @enderror" id="fax" name="fax">
                        @error('fax')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Input Alamat --}}
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Supplier</label>
                        <textarea name="address" id="address" rows="5" class="form-control">{{old('address', $supplier->id)}}</textarea>
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
