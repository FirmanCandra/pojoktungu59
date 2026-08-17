@extends('layouts.admin')

@section('title', 'Tambah Program Kerja')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Tambah Program Kerja Baru</h1>
    <a href="{{ route('admin.program-kerja.index') }}" class="btn btn-secondary">← Kembali ke List</a>
  </div>

  <div class="panel" style="max-width:800px">
    <form action="{{ route('admin.program-kerja.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <div class="form-group">
        <label for="title">Judul Program Kerja *</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: Digitalisasi UMKM Desa" class="form-control">
        @error('title') <div class="form-error">{{ $message }}</div> @enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="category">Bidang / Kategori</label>
          <select id="category" name="category" class="form-control">
            <option value="">— Pilih Bidang —</option>
            @foreach(config('categories.work_program') as $cat)
              <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          @error('category') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="status">Status Program Kerja *</label>
          <select id="status" name="status" class="form-control">
            <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
          </select>
          @error('status') <div class="form-error">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="form-group">
        <label for="description">Deskripsi Program Kerja *</label>
        <textarea id="description" name="description" required rows="8" placeholder="Jelaskan tujuan, ruang lingkup, dan detail program kerja..." class="form-control">{{ old('description') }}</textarea>
        @error('description') <div class="form-error">{{ $message }}</div> @enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="image">Gambar Header/Foto Kegiatan</label>
          <input type="file" id="image" name="image" accept="image/*" class="form-control">
          @error('image') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group" style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
          <div>
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control">
            @error('start_date') <div class="form-error">{{ $message }}</div> @enderror
          </div>
          <div>
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="form-control">
            @error('end_date') <div class="form-error">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="padding:10px 24px;margin-top:10px">Simpan Program Kerja</button>
    </form>
  </div>
@endsection
