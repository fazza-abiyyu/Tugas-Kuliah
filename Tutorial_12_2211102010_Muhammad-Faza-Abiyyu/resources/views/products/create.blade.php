@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="card">
    <div class="card-header">
        Tambah Produk
    </div>
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Produk</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}">
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Produk</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection