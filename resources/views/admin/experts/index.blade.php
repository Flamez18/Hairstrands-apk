@extends('layouts.admin')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Manajemen Dokter Ahli</h2>
    <a href="{{ route('admin.experts.create') }}" class="btn btn-primary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-plus"></i> Tambah Dokter</a>
</div>
<table class="admin-table">
    <thead><tr><th>#</th><th>Nama</th><th>Spesialisasi</th><th>Rating</th><th>Harga Konsultasi</th><th>Pengalaman</th><th>Aksi</th></tr></thead>
    <tbody>
        @forelse($experts as $expert)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="font-weight: 600;">{{ $expert->name }}</td>
            <td><span class="admin-badge badge-paid">{{ $expert->specialty }}</span></td>
            <td>⭐ {{ $expert->rating }}</td>
            <td>Rp {{ number_format($expert->price, 0, ',', '.') }}</td>
            <td>{{ $expert->experience }}</td>
            <td>
                <a href="{{ route('admin.experts.edit', $expert->id) }}" class="btn-sm btn-primary btn" style="width: auto; margin-right: 6px;"><i class="fa-solid fa-pen"></i> Edit</a>
                <form action="{{ route('admin.experts.destroy', $expert->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus dokter ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align: center; color: var(--text-muted);">Belum ada dokter.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
