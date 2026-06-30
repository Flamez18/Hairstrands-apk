@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Manajemen Produk</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Rating</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="font-weight: 600;">{{ $product->name }}</td>
            <td><span class="admin-badge badge-paid">{{ $product->category->name }}</span></td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>{{ $product->stock }} pcs</td>
            <td>⭐ {{ $product->rating }}</td>
            <td>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-sm btn-primary btn" style="width: auto; margin-right: 6px;"><i class="fa-solid fa-pen"></i> Edit</a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus produk ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align: center; color: var(--text-muted);">Belum ada produk.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
