@extends('layouts.admin')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Tambah Jadwal Dokter</h2>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>
<div style="max-width: 600px;">
    <form action="{{ route('admin.schedules.store') }}" method="POST">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif
        <div class="form-group">
            <label class="form-label">Pilih Dokter *</label>
            <select name="hair_expert_id" class="form-select" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach($experts as $expert)
                <option value="{{ $expert->id }}" {{ old('hair_expert_id') == $expert->id ? 'selected' : '' }}>{{ $expert->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Tanggal *</label>
            <input type="date" name="date" class="form-input" value="{{ old('date') }}" required min="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Pilih Slot Jam *</label>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 8px;">
                @foreach($timeSlots as $slot)
                <label style="display: flex; align-items: center; gap: 8px; border: 1px solid var(--border); border-radius: 10px; padding: 10px; cursor: pointer;">
                    <input type="checkbox" name="time_slots[]" value="{{ $slot }}" {{ in_array($slot, old('time_slots', [])) ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: var(--primary);">
                    <span style="font-weight: 600; font-size: 0.85rem;">{{ $slot }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 8px;">Simpan Jadwal</button>
    </form>
</div>
@endsection
