@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-6">
        <h2> Buat Produk</h2>
        <p class="text-muted">Tambahkan produk baru yang tesedia.</p>
    </div>
    <div class="col-6">

        <div class="card">
            <div class="card-body">
        <!-- Form Create User -->
                <form action="{{route ('products.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- Input Kategori --}}
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category" id="category" class="form-control @error('category')is-inavlid @enderror">
                            <option value="" selected disabled>Pilih salah satu</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{old('category') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Input Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input value="{{old('name')}}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Input Stok --}}
                    <div class="mb-3">
                        <label for="stock" class="form-label">Jumlah Stok</label>
                        <input value="{{old('stock')}}" type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock">
                        @error('stock')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Inpout Harga Modal Satuan --}}
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga Modal Satuan</label>
                        <input value="{{old('price')}}" type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price">
                        @error('price')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Input Harga Jual Satuan --}}
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Harga Jual Satuan</label>
                        <input value="{{old('selling_price')}}" type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price">
                        @error('selling_price')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- Input Deskripsi Produk --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk</label>
                        <textarea name="description" id="description" rows="5" class="form-control">{{old('description')}}</textarea>
                    </div>
                    {{-- Input Foto Produk --}}
                    <div class="mb-3">
                        <label for="photo_path">Foto Produk</label>
                        <input value="{{old('photo_path')}}" type="file" name="photo_path" id="photo_path" class="form-control @error('photo_path') is-invalid @enderror">
                        @error('photo_path')
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
