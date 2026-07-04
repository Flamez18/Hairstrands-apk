@extends('layouts.admin')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Tambah Dokter Ahli</h2>
    <a href="{{ route('admin.experts.index') }}" class="btn btn-secondary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>
<div style="max-width: 700px;">
    <form action="{{ route('admin.experts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Dr. Nama Dokter">
            </div>
            <div class="form-group">
                <label class="form-label">Spesialisasi *</label>
                <select name="specialty" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="Dermatologi" {{ old('specialty') === 'Dermatologi' ? 'selected' : '' }}>Dermatologi</option>
                    <option value="Hair Stylist" {{ old('specialty') === 'Hair Stylist' ? 'selected' : '' }}>Hair Stylist</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Rating (1-5) *</label>
                <input type="number" name="rating" class="form-input" value="{{ old('rating', 5.0) }}" step="0.1" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label class="form-label">Harga Konsultasi (Rp) *</label>
                <input type="number" name="price" class="form-input" value="{{ old('price') }}" required placeholder="50000">
            </div>
            <div class="form-group">
                <label class="form-label">Pengalaman *</label>
                <input type="text" name="experience" class="form-input" value="{{ old('experience') }}" required placeholder="8 thn pengalaman">
            </div>
            <div class="form-group">
                <label class="form-label">Profil Singkat</label>
                <input type="text" name="profile" class="form-input" value="{{ old('profile') }}" placeholder="Dermatologi & Kesehatan Rambut">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-textarea" rows="3" placeholder="Bio singkat dokter">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Foto Dokter</label>
            <input type="file" name="photo_file" class="form-input" style="margin-bottom: 4px;">
            <input type="text" name="photo" class="form-input" value="{{ old('photo') }}" placeholder="Atau masukkan nama file manual (opsional)">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 8px;">Simpan Dokter</button>
    </form>
</div>
@endsection
