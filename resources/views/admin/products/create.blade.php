@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Tambah Produk</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div style="max-width: 700px;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label">Kategori *</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Produk *</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Contoh: Velvet Black Dye">
            </div>
            <div class="form-group">
                <label class="form-label">Harga (Rupiah) *</label>
                <input type="number" name="price" class="form-input" value="{{ old('price') }}" required placeholder="95000">
            </div>
            <div class="form-group">
                <label class="form-label">Stok *</label>
                <input type="number" name="stock" class="form-input" value="{{ old('stock', 0) }}" required placeholder="10">
            </div>
            <div class="form-group">
                <label class="form-label">Rating (1-5)</label>
                <input type="number" name="rating" class="form-input" value="{{ old('rating', 5.0) }}" step="0.1" min="1" max="5">
            </div>
            <div class="form-group">
                <label class="form-label">Gambar Produk</label>
                <input type="file" name="image_file" class="form-input" style="margin-bottom: 4px;">
                <input type="text" name="image" class="form-input" value="{{ old('image') }}" placeholder="Atau masukkan nama file manual (opsional)">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi Produk</label>
            <textarea name="description" class="form-textarea" rows="4" placeholder="Deskripsi produk lengkap...">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Pilihan Warna/Shades (Kode Hex dipisah koma)</label>
            <input type="text" name="shades" class="form-input" value="{{ old('shades') }}" placeholder="Contoh: #1F1F1F, #2A2533, #4A3B32">
            <small style="color: var(--text-muted);">Kosongkan jika produk tidak memiliki pilihan warna.</small>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 8px;">Simpan Produk</button>
    </form>
</div>
@endsection
