@extends('layouts.admin')

@section('title', 'Edit Visi & Misi')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Kelola Visi & Misi</h1>
  </div>

  <div class="panel" style="max-width:800px">
    <p style="font-size:11px;color:#666;margin-bottom:20px">Konten Visi & Misi ini disimpan sebagai data publik dan akan langsung tampil pada halaman "Visi & Misi" pengunjung.</p>

    <form action="{{ route('admin.vision-mission.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="vision">Pernyataan Visi KKN *</label>
        <textarea id="vision" name="vision" required rows="4" placeholder="Tuliskan pernyataan visi KKN..." class="form-control">{{ old('vision', $visionMission->vision) }}</textarea>
        @error('vision') <div class="form-error">{{ $message }}</div> @enderror
      </div>

      <div class="form-group">
        <label for="mission">Point-point Misi KKN *</label>
        <textarea id="mission" name="mission" required rows="8" placeholder="1. Misi pertama&#10;2. Misi kedua&#10;3. Misi ketiga..." class="form-control">{{ old('mission', $visionMission->mission) }}</textarea>
        <small class="form-text">Gunakan baris baru (enter) atau penomoran untuk memisahkan setiap poin misi.</small>
        @error('mission') <div class="form-error">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn btn-primary" style="padding:10px 24px">Simpan Perubahan Visi & Misi</button>
    </form>
  </div>
@endsection
