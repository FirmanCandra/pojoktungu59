@extends('layouts.admin')

@section('title', 'Pengaturan Situs')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Pengaturan Situs</h1>
  </div>

  <div class="panel" style="max-width:800px">
    <form action="{{ route('admin.settings.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="panel-title">Informasi Utama Website</div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="site_name">Nama Website / Organisasi *</label>
          <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required class="form-control">
          @error('site_name') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="site_tagline">Tagline / Slogan</label>
          <input type="text" id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" class="form-control">
        </div>
      </div>

      <div class="panel-title" style="margin-top:24px">Kontak & Alamat</div>

      <div class="form-group">
        <label for="address">Alamat Lengkap Sekretariat</label>
        <textarea id="address" name="address" rows="3" class="form-control">{{ old('address', $settings['address']) }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="phone">Nomor Telepon / WhatsApp</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone', $settings['phone']) }}" class="form-control">
        </div>

        <div class="form-group">
          <label for="email">Alamat Email Resmi</label>
          <input type="email" id="email" name="email" value="{{ old('email', $settings['email']) }}" class="form-control">
          @error('email') <div class="form-error">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="form-group">
        <label for="maps">Embed Code Google Maps (iframe HTML)</label>
        <textarea id="maps" name="maps" rows="3" placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' class="form-control">{{ old('maps', $settings['maps']) }}</textarea>
        <small class="form-text">Dapatkan kode ini dari Google Maps > Share > Embed a map.</small>
      </div>

      <div class="panel-title" style="margin-top:24px">Tautan Media Sosial</div>

      <div class="form-row">
        <div class="form-group">
          <label for="instagram">Link Instagram</label>
          <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $settings['instagram'] ?? '') }}" placeholder="https://instagram.com/..." class="form-control">
        </div>

        <div class="form-group">
          <label for="tiktok">Link TikTok</label>
          <input type="text" id="tiktok" name="tiktok" value="{{ old('tiktok', $settings['tiktok'] ?? '') }}" placeholder="https://www.tiktok.com/@..." class="form-control">
        </div>
      </div>

      </div>

      <button type="submit" class="btn btn-primary" style="padding:10px 28px;margin-top:10px">Simpan Semua Pengaturan</button>
    </form>
  </div>
@endsection
