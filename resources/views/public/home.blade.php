@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
  <style>
    /* ── Hero ── */
    .hero{max-width:1180px;margin:24px auto 0;padding:0 18px;height:360px}
    .hero-copy{height:100%;border-radius:10px;padding:180px 44% 28px 32px;color:#fff;background:linear-gradient(100deg,rgba(4,17,42,.88),rgba(5,23,50,.15)),url('{{ $featuredArticle ? $featuredArticle->thumbnail_url : "https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1500&q=85" }}') center/cover;display:flex;flex-direction:column;justify-content:flex-end;position:relative}
    .hero h1{font-family:'Playfair Display',serif;font-size:24px;line-height:1.25;margin:8px 0}
    .hero h1 a{color:#fff}
    .hero h1 a:hover{text-decoration:underline}
    .hero p{font-size:11.5px;line-height:1.5;margin:0 0 12px;opacity:.88}

    /* ── Section Header ── */
    .sec-hd{display:flex;justify-content:space-between;align-items:center;border-left:3px solid var(--blue);padding-left:9px;margin-bottom:12px}
    .sec-hd h2{margin:0;font-size:15px}
    .sec-hd a{font-size:10px;color:var(--blue);font-weight:600}

    /* ── Artikel Grid 3 Kolom ── */
    .home-art-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
    .card{background:#fff;border:1px solid var(--line);border-radius:8px;overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .2s,transform .2s}
    .card:hover{box-shadow:0 6px 24px rgba(20,91,215,.1);transform:translateY(-2px)}
    .card-image{height:110px;background-size:cover;background-position:center}
    .card-body{padding:10px 12px;flex:1;display:flex;flex-direction:column}
    .art-cat-label{font-size:8px;font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.5px}
    .card h3{font-size:12.5px;line-height:1.3;margin:5px 0 4px;font-weight:600}
    .card h3 a{color:var(--ink)}
    .card h3 a:hover{color:var(--blue)}
    .card p{font-size:10px;color:var(--muted);line-height:1.4;margin:0 0 8px;flex:1}
    .card-foot{display:flex;align-items:center;justify-content:space-between;border-top:1px solid #f0f4f9;padding-top:7px;margin-top:auto}
    .card-foot-left{display:flex;align-items:center;gap:5px;font-size:9px;color:#64718a}
    .card-foot-link{font-size:9px;font-weight:700;color:var(--blue);white-space:nowrap}
    .card-foot-link:hover{text-decoration:underline}

    /* ── Program Kerja Grid 3 Kolom ── */
    .home-prog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:4px}
    .prog-card{background:#fff;border:1px solid var(--line);border-radius:8px;overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .2s,transform .2s}
    .prog-card:hover{box-shadow:0 6px 24px rgba(20,91,215,.1);transform:translateY(-2px)}
    .prog-img{height:100px;background-size:cover;background-position:center}
    .prog-body{padding:10px 12px;flex:1;display:flex;flex-direction:column}
    .prog-body h3{font-size:12.5px;line-height:1.3;margin:5px 0 4px;font-weight:600}
    .prog-body h3 a{color:var(--ink)}
    .prog-body h3 a:hover{color:var(--blue)}
    .prog-body p{font-size:10px;color:var(--muted);line-height:1.4;margin:0 0 8px;flex:1}
    .prog-foot{display:flex;align-items:center;justify-content:space-between;border-top:1px solid #f0f4f9;padding-top:7px;margin-top:auto}
    .prog-date{font-size:9px;color:#888}
    .prog-link{font-size:9px;font-weight:700;color:var(--blue);white-space:nowrap}
    .prog-link:hover{text-decoration:underline}
    .status-dot{display:inline-flex;align-items:center;font-size:8px;font-weight:700;padding:2px 7px;border-radius:20px;width:fit-content;margin-bottom:4px}
    .dot-berjalan{background:#e3f2fd;color:#1565c0}
    .dot-selesai{background:#e8f5e9;color:#2e7d32}
    .dot-belum{background:#fff3e0;color:#e65100}

    /* ── Hoax Block ── */
    .hoax-block{background:#fff;border:1px solid #e2e8f0;border-top:3px solid #dc2626;border-radius:8px;padding:14px}
    .hoax-header{display:flex;align-items:center;gap:8px;margin-bottom:10px;padding-bottom:8px;border-bottom:1px solid #f1f5f9}
    .hoax-icon{width:28px;height:28px;background:#fee2e2;color:#dc2626;border-radius:7px;display:grid;place-items:center;font-size:13px;flex-shrink:0}
    .hoax-header h3{font-size:12px;color:#0f172a;margin:0;font-weight:700}
    .hoax-header span{display:block;font-size:8px;color:#dc2626;font-weight:600}
    .hoax-item{border:1px solid #e2e8f0;border-left:3px solid #dc2626;border-radius:6px;padding:10px 12px;margin-bottom:8px;transition:box-shadow .2s}
    .hoax-item:last-child{margin-bottom:0}
    .hoax-item:hover{box-shadow:0 3px 10px rgba(0,0,0,.06)}
    .hoax-item-title{font-size:11px;font-weight:700;color:#1e293b;margin:5px 0 4px;line-height:1.35}
    .hoax-item-desc{font-size:10px;color:#475569;line-height:1.55;margin:0;white-space:pre-wrap;word-break:break-word}
    .hoax-badge{display:inline-block;font-size:7.5px;font-weight:700;padding:2px 6px;border-radius:4px;letter-spacing:.3px}

    /* ── CTA Banner ── */
    .cta-banner{background:linear-gradient(135deg,#145bd7,#0a3b93);color:#fff;border-radius:8px;padding:24px 28px;text-align:center;margin-top:28px}
    .cta-banner h2{color:#fff;font-size:18px;margin-bottom:6px}
    .cta-banner p{font-size:11px;opacity:.9;margin-bottom:14px}

    @media(max-width:760px){
      .hero{height:310px;padding:0 12px}
      .hero-copy{padding:130px 18px 20px}
      .home-art-grid{grid-template-columns:1fr}
      .home-prog-grid{grid-template-columns:1fr}
      /* Sidebar di mobile: tampil dalam satu kolom di bawah main content */
      .hoax-block{border-top-width:4px}
      .hoax-item-title{font-size:12px}
      .hoax-item-desc{font-size:10.5px;line-height:1.6}
      .cta-banner{padding:18px 16px}
      .cta-banner h2{font-size:16px}
    }
  </style>

  {{-- Hero Section --}}
  <section class="hero">
    <div class="hero-copy">
      <div><span class="tag">FEATURED</span></div>
      @if($featuredArticle)
        <h1><a href="{{ route('articles.show', $featuredArticle->slug) }}">{{ $featuredArticle->title }}</a></h1>
        <p>{{ Str::limit(strip_tags($featuredArticle->content), 110) }}</p>
        <div class="byline">
          <span class="avatar">{{ strtoupper(substr($featuredArticle->user->name ?? 'Admin', 0, 1)) }}</span>
          {{ $featuredArticle->user->name ?? 'Admin' }}
          <i>•</i> {{ $featuredArticle->published_at ? $featuredArticle->published_at->translatedFormat('d F Y') : $featuredArticle->created_at->translatedFormat('d F Y') }}
        </div>
      @else
        <h1>Selamat Datang di Pojok Informasi</h1>
        <p>Temukan artikel inspiratif, berita kegiatan, dan informasi program kerja terbaru di sini.</p>
      @endif
    </div>
  </section>

  {{-- Main Content --}}
  <section class="content-grid">
    <div class="main-content">

      {{-- Artikel Terbaru --}}
      <div class="sec-hd">
        <h2>Artikel Terbaru</h2>
        <a href="{{ route('articles.index') }}">Lihat Semua →</a>
      </div>

      <div class="home-art-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
        @forelse($recentArticles->take(3) as $art)
          <article class="card">
            <div class="card-image" style="background-image:url('{{ $art->thumbnail_url }}')"></div>
            <div class="card-body">
              <span class="art-cat-label">{{ strtoupper($art->category) }}</span>
              <h3><a href="{{ route('articles.show', $art->slug) }}">{{ Str::limit($art->title, 40) }}</a></h3>
              <p>{{ Str::limit(strip_tags($art->content), 55) }}</p>
              <div class="card-foot">
                <div class="card-foot-left">
                  <span class="avatar">{{ strtoupper(substr($art->user->name ?? 'A', 0, 1)) }}</span>
                  <span>{{ $art->created_at->format('d M Y') }}</span>
                </div>
                <a href="{{ route('articles.show', $art->slug) }}" class="card-foot-link">Baca →</a>
              </div>
            </div>
          </article>
        @empty
          <p style="grid-column:1/-1;font-size:12px;color:#777">Belum ada artikel dipublikasikan.</p>
        @endforelse
      </div>

      {{-- Program Kerja --}}
      <div class="sec-hd" style="margin-top:30px">
        <h2>Program Kerja</h2>
        <a href="{{ route('work-programs.index') }}">Lihat Semua →</a>
      </div>

      <div class="home-prog-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
        @forelse($workPrograms->take(3) as $prog)
          <div class="prog-card">
            <div class="prog-img" style="background-image:url('{{ $prog->image_url }}')"></div>
            <div class="prog-body">
              @php
                $dotClass = match($prog->status) {
                  'berjalan' => 'dot-berjalan',
                  'selesai'  => 'dot-selesai',
                  default    => 'dot-belum',
                };
              @endphp
              <span class="status-dot {{ $dotClass }}">{{ strtoupper($prog->status) }}</span>
              <h3><a href="{{ route('work-programs.show', $prog->slug) }}">{{ Str::limit($prog->title, 38) }}</a></h3>
              <p>{{ Str::limit(strip_tags($prog->description), 55) }}</p>
              <div class="prog-foot">
                <span class="prog-date">📅 {{ $prog->start_date ? $prog->start_date->format('d/m/Y') : '—' }}</span>
                <a href="{{ route('work-programs.show', $prog->slug) }}" class="prog-link">Detail →</a>
              </div>
            </div>
          </div>
        @empty
          <p style="grid-column:1/-1;font-size:12px;color:#777">Belum ada program kerja.</p>
        @endforelse
      </div>

      {{-- CTA Banner --}}
      <div class="cta-banner">
        <h2>Punya Pertanyaan atau Masukan?</h2>
        <p>Kami sangat terbuka untuk mendengar tanggapan, saran, maupun kolaborasi dari Anda.</p>
        <a href="{{ route('contact') }}" class="primary" style="background:#fff;color:var(--blue);font-weight:600;padding:9px 20px;display:inline-block">Hubungi Kami Sekarang</a>
      </div>
    </div>

    {{-- Sidebar --}}
    <aside class="sidebar">

      {{-- Pencegahan Hoax --}}
      <div class="hoax-block">
        <div class="hoax-header">
          <div class="hoax-icon">🛡️</div>
          <div>
            <h3>Pencegahan Hoax & Info</h3>
            <span>Klarifikasi Resmi Desa</span>
          </div>
        </div>
        @forelse($announcements as $ann)
          <div class="hoax-item" style="border-left-color:{{ $ann->type_badge_color }}">
            <span class="hoax-badge" style="background:{{ $ann->type_badge_color }}18;color:{{ $ann->type_badge_color }};border:1px solid {{ $ann->type_badge_color }}33">
              {{ $ann->type_label }}
            </span>
            <div class="hoax-item-title">{{ $ann->title }}</div>
            <p class="hoax-item-desc">{!! nl2br(e($ann->content)) !!}</p>
          </div>
        @empty
          <p style="font-size:10px;color:#777;margin:0">Belum ada pengumuman.</p>
        @endforelse
      </div>

      {{-- Search --}}
      <form class="search-box" action="{{ route('articles.index') }}" method="GET">
        <input name="q" placeholder="Cari artikel..." value="{{ request('q') }}" />
        <button type="submit" class="primary">Cari</button>
      </form>

      {{-- Visi & Misi --}}
      <div class="side-block">
        <h3>Visi & Misi KKN</h3>
        <p style="font-size:11px;color:#555;line-height:1.4;margin:0 0 10px">
          {{ Str::limit(\App\Models\VisionMission::getInstance()->vision, 115) }}
        </p>
        <a href="{{ route('vision-mission') }}" style="font-size:10px;font-weight:600">Selengkapnya →</a>
      </div>

      {{-- Kontak --}}
      <div class="side-block">
        <h3>Informasi Kontak</h3>
        <ul style="font-size:10px">
          <li style="flex-direction:column;gap:3px;align-items:flex-start">
            <strong>Alamat:</strong>
            <span style="color:#666">{{ \App\Models\SiteSetting::get('address', 'WPC7+H8Q, Tungu, Kec. Godong') }}</span>
          </li>
          <li style="flex-direction:column;gap:3px;align-items:flex-start">
            <strong>Telepon/WA:</strong>
            <span style="color:#666">{{ \App\Models\SiteSetting::get('phone', '+62 812-3456-7890') }}</span>
          </li>
          <li style="flex-direction:column;gap:3px;align-items:flex-start">
            <strong>Email:</strong>
            <span style="color:#666">{{ \App\Models\SiteSetting::get('email', 'info@pojokinfo.id') }}</span>
          </li>
        </ul>
      </div>
    </aside>
  </section>
@endsection
