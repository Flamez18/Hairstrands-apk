@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Tambah Kategori</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div style="max-width: 600px;">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif
        <div class="form-group">
            <label class="form-label">Nama Kategori *</label>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Contoh: Perawatan Rambut">
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-textarea" rows="3" placeholder="Deskripsi singkat kategori">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Nama File Gambar</label>
            <input type="text" name="image" class="form-input" value="{{ old('image') }}" placeholder="Contoh: category_perawatan.png">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 8px;">Simpan Kategori</button>
    </form>
</div>
@endsection
