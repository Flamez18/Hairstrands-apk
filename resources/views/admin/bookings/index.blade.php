@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Manajemen Booking Konsultasi</h2>
</div>
<table class="admin-table">
    <thead><tr><th>#</th><th>Pengguna</th><th>Dokter</th><th>Tanggal & Jam</th><th>Tipe</th><th>Keluhan</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
        @forelse($bookings as $booking)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="font-weight: 600;">{{ $booking->user->name }}</td>
            <td>{{ $booking->expert->name }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}<br><small>{{ $booking->schedule->time_slot }} WIB</small></td>
            <td><span class="admin-badge badge-paid">{{ $booking->type }}</span></td>
            <td style="max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $booking->complaint ?? '-' }}</td>
            <td>
                <span class="admin-badge badge-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'cancelled' ? 'cancelled' : 'pending') }}">
                    {{ strtoupper($booking->status) }}
                </span>
            </td>
            <td>
                <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" style="display: flex; gap: 6px; align-items: center; margin: 0;">
                    @csrf
                    <select name="status" class="form-select" style="padding: 4px 8px; font-size: 0.8rem; height: auto; width: auto; min-width: 100px;">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-primary" style="padding: 4px 10px; font-size: 0.8rem; width: auto;"><i class="fa-solid fa-check"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align: center; color: var(--text-muted);">Belum ada booking.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
