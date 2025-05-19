@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="products-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->nama }}</td>
                    <td>Rp{{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#products-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            }
        });
    });
</script>
@endpush