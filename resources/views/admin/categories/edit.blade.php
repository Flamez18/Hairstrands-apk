@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 1.4rem; font-weight: 800;">Edit Kategori: {{ $category->name }}</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm" style="width: auto; padding: 10px 20px;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div style="max-width: 600px;">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif
        <div class="form-group">
            <label class="form-label">Nama Kategori *</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-textarea" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Nama File Gambar</label>
            <input type="text" name="image" class="form-input" value="{{ old('image', $category->image) }}">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 8px;">Update Kategori</button>
    </form>
</div>
@endsection
