@extends('layouts.app')

@section('content')

{{-- @can untuk mengakses policy yang return true, sedangkan @cannot untuk return false --}}
@can('create', App\Models\Supplier::class)
<div class="row justify-content-end">
    <div class="col-1 align-content-end">
        <a href="{{route ('suppliers.create') }}" class="btn btn-primary w-100">Buat</a>
    </div>
</div>
@endcan

{{-- komponen message --}}
<x-message />

<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Supplier</th>
            <th>Alamat Supplier</th>
            <th>No Telepon</th>
            <th>Fax</th>
            @can('viewOpsi', App\Models\Supplier::class)
            <th>Opsi</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @forelse ($suppliers as $i => $supplier)
        <tr>
            <td>{{$i + 1}}</td>
            <td>{{$supplier->name}}</td>
            <td>{{$supplier->address}}</td>
            <td>{{$supplier->phone}}</td>
            <td>{{$supplier->fax}}</td>
            @can('update', $supplier)
            <td>
                <a href="{{route('suppliers.edit', $supplier->id)}}" class="btn btn-secondary btn-xs">Ubah</a>
                <button class="btn btn-danger btn-xs" onclick="confirm('Yakin ingin menghapus?') ? document.getElementById('delete-{{$supplier->id}}').submit() : null">Hapus</button>
            </td>
            @endcan
            <td>
                <form action="{{route('suppliers.destroy', $supplier->id)}}" method="post" id="delete-{{$supplier->id}}">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">Data tidak ditemukan atau masih kosong</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
