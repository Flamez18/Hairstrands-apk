@extends('layouts.admin')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Manajemen Jadwal Dokter</h2>
    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-plus"></i> Tambah Jadwal</a>
</div>
<table class="admin-table">
    <thead><tr><th>#</th><th>Dokter</th><th>Tanggal</th><th>Jam</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
        @forelse($schedules as $schedule)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="font-weight: 600;">{{ $schedule->expert->name }}</td>
            <td>{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</td>
            <td>{{ $schedule->time_slot }} WIB</td>
            <td>
                @if($schedule->is_booked)
                    <span class="admin-badge badge-cancelled">Terpesan</span>
                @else
                    <span class="admin-badge badge-success">Tersedia</span>
                @endif
            </td>
            <td>
                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus jadwal ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada jadwal.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
