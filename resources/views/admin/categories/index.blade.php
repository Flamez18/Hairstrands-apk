@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Manajemen Kategori</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-plus"></i> Tambah Kategori</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Kategori</th>
            <th>Slug</th>
            <th>Deskripsi</th>
            <th>Jumlah Produk</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="font-weight: 600;">{{ $category->name }}</td>
            <td><code>{{ $category->slug }}</code></td>
            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $category->description }}</td>
            <td>{{ $category->products->count() }} produk</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-sm btn-primary btn" style="width: auto; margin-right: 6px;"><i class="fa-solid fa-pen"></i> Edit</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada kategori.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
