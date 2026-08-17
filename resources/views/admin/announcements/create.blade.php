@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Tambah Pengumuman / Cegah Hoax</h1>
    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">← Kembali ke List</a>
  </div>

  <div class="panel" style="max-width:700px">
    <form action="{{ route('admin.pengumuman.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="title">Judul Pengumuman / Klarifikasi *</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: [KLARIFIKASI HOAX] Isu Pembagian Sembako Gratis" class="form-control">
        @error('title') <div class="form-error">{{ $message }}</div> @enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="type">Kategori / Tipe *</label>
          <select id="type" name="type" class="form-control">
            <option value="hoax" {{ old('type') == 'hoax' ? 'selected' : '' }}>🚫 Klarifikasi Hoax (Pencegahan Hoax)</option>
            <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>⚠️ Peringatan Waspada</option>
            <option value="penting" {{ old('type') == 'penting' ? 'selected' : '' }}>📢 Pengumuman Penting</option>
            <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>ℹ️ Informasi Umum</option>
          </select>
          @error('type') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="is_active">Status Tampil</label>
          <select id="is_active" name="is_active" class="form-control">
            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Tampilkan)</option>
            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="content">Isi Pengumuman / Fakta Sebenarnya *</label>
        <textarea id="content" name="content" required rows="6" placeholder="Jelaskan fakta sebenarnya secara jelas dan akurat..." class="form-control">{{ old('content') }}</textarea>
        @error('content') <div class="form-error">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn btn-primary" style="padding:10px 24px">Simpan Pengumuman</button>
    </form>
  </div>
@endsection
