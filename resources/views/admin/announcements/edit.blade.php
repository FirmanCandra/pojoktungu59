@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Edit Pengumuman</h1>
    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">← Kembali ke List</a>
  </div>

  <div class="panel" style="max-width:700px">
    <form action="{{ route('admin.pengumuman.update', $announcement->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="title">Judul Pengumuman / Klarifikasi *</label>
        <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" required class="form-control">
        @error('title') <div class="form-error">{{ $message }}</div> @enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="type">Kategori / Tipe *</label>
          <select id="type" name="type" class="form-control">
            <option value="hoax" {{ old('type', $announcement->type) == 'hoax' ? 'selected' : '' }}>🚫 Klarifikasi Hoax (Pencegahan Hoax)</option>
            <option value="warning" {{ old('type', $announcement->type) == 'warning' ? 'selected' : '' }}>⚠️ Peringatan Waspada</option>
            <option value="penting" {{ old('type', $announcement->type) == 'penting' ? 'selected' : '' }}>📢 Pengumuman Penting</option>
            <option value="info" {{ old('type', $announcement->type) == 'info' ? 'selected' : '' }}>ℹ️ Informasi Umum</option>
          </select>
          @error('type') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="is_active">Status Tampil</label>
          <select id="is_active" name="is_active" class="form-control">
            <option value="1" {{ old('is_active', $announcement->is_active) ? 'selected' : '' }}>Aktif (Tampilkan)</option>
            <option value="0" {{ !old('is_active', $announcement->is_active) ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="content">Isi Pengumuman / Fakta Sebenarnya *</label>
        <textarea id="content" name="content" required rows="6" class="form-control">{{ old('content', $announcement->content) }}</textarea>
        @error('content') <div class="form-error">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn btn-primary" style="padding:10px 24px">Update Pengumuman</button>
    </form>
  </div>
@endsection
