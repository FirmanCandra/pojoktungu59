@extends('layouts.public')

@section('title', 'Kontak')

@section('content')
  <section class="section-pad">
    <p class="eyebrow"><a href="{{ route('home') }}">Beranda</a> / Kontak</p>
    <h2>Hubungi Kami</h2>
    <p style="font-size:12px;color:var(--muted);margin-bottom:28px">Kirimkan pesan, tanggapan, atau kritik dan saran melalui form di bawah ini.</p>

    @if(session('success'))
      <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:36px">
      <!-- Contact Form -->
      <div>
        <form action="{{ route('contact.store') }}" method="POST" style="display:grid;gap:14px">
          @csrf
          <div>
            <label style="font-size:11px;font-weight:600;display:block;margin-bottom:4px">Nama Lengkap *</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama Anda" style="width:100%;padding:9px;border:1px solid var(--line);border-radius:4px;font-size:12px">
            @error('name') <span style="color:red;font-size:10px">{{ $message }}</span> @enderror
          </div>

          <div>
            <label style="font-size:11px;font-weight:600;display:block;margin-bottom:4px">Alamat Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com" style="width:100%;padding:9px;border:1px solid var(--line);border-radius:4px;font-size:12px">
            @error('email') <span style="color:red;font-size:10px">{{ $message }}</span> @enderror
          </div>

          <div>
            <label style="font-size:11px;font-weight:600;display:block;margin-bottom:4px">Subjek *</label>
            <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Subjek pesan" style="width:100%;padding:9px;border:1px solid var(--line);border-radius:4px;font-size:12px">
            @error('subject') <span style="color:red;font-size:10px">{{ $message }}</span> @enderror
          </div>

          <div>
            <label style="font-size:11px;font-weight:600;display:block;margin-bottom:4px">Pesan *</label>
            <textarea name="message" required rows="5" placeholder="Tuliskan pesan Anda di sini..." style="width:100%;padding:9px;border:1px solid var(--line);border-radius:4px;font-size:12px;resize:vertical">{{ old('message') }}</textarea>
            @error('message') <span style="color:red;font-size:10px">{{ $message }}</span> @enderror
          </div>

          <button type="submit" class="primary" style="padding:10px;font-size:12px;margin-top:6px">Kirim Pesan Sekarang</button>
        </form>
      </div>

      <!-- Info & Maps -->
      <div style="display:flex;flex-direction:column;gap:20px">
        <div style="background:#f8fafc;border:1px solid var(--line);border-radius:6px;padding:20px">
          <h3 style="font-size:14px;margin-bottom:12px">Informasi Sekretariat</h3>
          <p style="font-size:11px;color:#475569;margin-bottom:8px">📍 <strong>Alamat:</strong> {{ $settings['address'] }}</p>
          <p style="font-size:11px;color:#475569;margin-bottom:8px">📞 <strong>Telepon:</strong> {{ $settings['phone'] }}</p>
          <p style="font-size:11px;color:#475569;margin-bottom:0">✉ <strong>Email:</strong> {{ $settings['email'] }}</p>
        </div>

        @if(!empty($settings['maps']))
          <div style="border:1px solid var(--line);border-radius:6px;overflow:hidden;height:240px">
            {!! $settings['maps'] !!}
          </div>
        @else
          <div style="border:1px dashed var(--line);border-radius:6px;height:200px;display:grid;place-items:center;color:#94a3b8;font-size:11px">
            (Embed Google Maps belum diatur di Admin Panel)
          </div>
        @endif
      </div>
    </div>
  </section>
@endsection
