@extends('layouts.app')

@section('content')

@can('create', App\Models\Category::class)
<div class="row justify-content-end">
    <div class="col-1 align-content-end">
        <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary w-100">Buat</button>
    </div>
</div>
@endcan

{{-- Modal Create --}}
<x-modal id="createModal">
    <x-slot name="title">Tambah Kategori</x-slot>
    <x-slot name="content">
        <form id="frmCreate" action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name"> Nama Kategori</label>
            <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror">
        </div>
        </form>
    </x-slot>
    <x-slot name="action">
        <button onclick="document.getElementById('frmCreate').submit()" type="button" class="btn btn-primary ml-2">Simpan</button>
    </x-slot>
</x-modal>

{{-- komponen message --}}
<x-message />

<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jumlah Produk</th>
            <th>Foto</th>
            <th>Dibuat Oleh</th>
            @can('viewOpsi', App\Models\Category::class)
            <th>Opsi</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $i => $category)
            <tr>
                <td>{{$i + 1}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->products->count()}}</td>
                <td>
                    @if ($category->photo_path)
                        <img src="{{url('storage/'. $category->photo_path)}}" alt="" style="width:200px; height:auto;">
                    @else
                        {{'--'}}
                    @endif
                </td>
                {{-- ?? berarti atau --}}
                {{-- bacanya ambil nama dari kategori user, jika tidak ada tampilkan 'sudah dihapus' --}}
                <td>{{$category->user->name ?? 'sudah dihapus' }}</td>
                @can('update', $category)
                <td>
                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$category->id}}">Ubah</button>
                    <x-modal id="editModal{{$category->id}}">
                        <x-slot name="title">Ubah Kategori {{$category->name}}</x-slot>
                        <x-slot name="content">
                            <form id="frmEdit{{$category->id}}" action="{{route('categories.update',$category->id)}}" method="post" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label for="name"> Nama Kategori </label>
                                <input type="text" name="name" id="name" value="{{old('name', $category->name)}}" class="form-control @error('name') is-invalid @enderror">
                            </div>
                            </form>
                        </x-slot>
                        <x-slot name="action">
                            <button onclick="document.getElementById('frmEdit{{$category->id}}').submit()" type="button" class="btn btn-primary ml-2">Ubah</button>
                        </x-slot>
                    </x-modal>

                    {{-- form delete category --}}
                    <form action="{{route('categories.destroy', $category->id)}}" method="post" style="display:none;" id="frmDelete{{$category->id}}">
                        @csrf @method('DELETE')
                    </form>
                    <button class="btn btn-sm btn-danger" onclick="if(confirm('Yakin ingin hapus?')) document.getElementById('frmDelete{{$category->id}}').submit()">Hapus</button>
                </td>
                @endcan
            </tr>
        @empty
            <tr>
                <td colspan="5">Data tidak ditemukan atau masih kosong.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
