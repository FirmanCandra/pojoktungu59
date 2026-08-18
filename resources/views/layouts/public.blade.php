<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Pojok Informasi') — Pojok Informasi</title>
  <meta name="description" content="@yield('meta_description', 'Informasi Aktual, Inspiratif, dan Bermanfaat')">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    :root{--blue:#145bd7;--ink:#13213d;--muted:#63708a;--line:#e4eaf3;--bg:#f5f8fc}
    *{box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{margin:0;font-family:'DM Sans',sans-serif;color:var(--ink);background:var(--bg)}
    a{color:var(--blue);text-decoration:none;cursor:pointer}
    button{font:inherit;cursor:pointer;border:0}

    /* ── Header ── */
    .site-header{height:80px;background:#fff;display:flex;align-items:center;gap:32px;padding:0 max(4vw,28px);border-bottom:1px solid var(--line);position:sticky;z-index:100;top:0}
    .brand{display:flex;align-items:center;gap:9px;color:#101a30;font-weight:700;font-size:16px;white-space:nowrap}
    .brand small{display:block;font-size:8px;color:#6f7786;font-weight:400}
    .brand-mark{background:var(--blue);color:#fff;border-radius:50%;width:30px;height:30px;display:grid;place-items:center;font-size:18px}
    nav{display:flex;gap:26px;margin-left:auto}
    nav a{font-size:12px;color:#1c2740;transition:color .2s}
    nav a:hover,nav a.active{color:var(--blue);font-weight:700}
    .menu-button{display:none;background:none;font-size:20px;margin-left:auto}

    /* ── Utilities ── */
    .tag{font-size:9px;background:var(--blue);color:#fff;padding:5px 8px;border-radius:3px;font-weight:700}
    .tag.light{background:rgba(20,91,215,.12);color:var(--blue)}
    .primary{background:var(--blue);color:#fff;border-radius:3px;padding:7px 13px;font-size:11px;border:none;cursor:pointer;transition:background .2s}
    .primary:hover{background:#0f4bb8}
    .btn-outline{background:none;border:1px solid var(--blue);color:var(--blue);border-radius:3px;padding:7px 13px;font-size:11px;cursor:pointer}
    .section-pad{max-width:1180px;margin:0 auto 44px;padding:35px 18px;background:#fff;border-radius:6px}
    .eyebrow{font-size:10px;color:#60718e;margin:0 0 8px}
    h2{font-size:19px;margin:0 0 .5rem}
    .section-title{display:flex;justify-content:space-between;align-items:center;border-left:3px solid var(--blue);padding-left:8px;margin-bottom:17px}
    .section-title h2{margin:0}
    .section-title a{font-size:11px}
    .byline{display:flex;align-items:center;gap:7px;font-size:10px;color:#eef3ff}
    .byline.dark{color:#657187}
    .byline i{font-style:normal;color:#9db1d5}
    .avatar{display:grid;place-items:center;width:20px;height:20px;border-radius:50%;background:#efbc88;color:#542b0c;font-size:9px;flex-shrink:0}
    .category{font-size:8px;color:var(--blue);font-weight:700}

    /* ── Cards Grid ── */
    .cards{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
    .card{background:#fff;border:1px solid var(--line);border-radius:5px;overflow:hidden;transition:box-shadow .2s,transform .2s}
    .card:hover{box-shadow:0 6px 24px rgba(20,91,215,.1);transform:translateY(-2px)}
    .card-image{height:115px;background-size:cover;background-position:center}
    .card-body{padding:12px}
    .card h3{font-size:13px;line-height:1.35;margin:7px 0}
    .card p{font-size:10px;color:var(--muted);line-height:1.45;margin:0 0 12px}
    .card .byline{color:#64718a;font-size:9px}

    /* ── List Items ── */
    .article-list{display:grid;gap:10px;max-width:730px}
    .list-item{display:grid;grid-template-columns:165px 1fr;gap:15px;padding:11px;border:1px solid var(--line);border-radius:4px;background:#fff;transition:box-shadow .2s}
    .list-item:hover{box-shadow:0 4px 16px rgba(20,91,215,.08)}
    .list-item img{width:165px;height:100px;object-fit:cover;border-radius:3px}
    .list-item h3{font-size:14px;margin:7px 0}
    .list-item p{font-size:10px;color:#6a758b;margin:0 0 10px;line-height:1.4}

    /* ── Sidebar ── */
    .sidebar{display:flex;flex-direction:column;gap:14px}
    .sidebar.compact{}
    .search-box{display:flex;padding:8px;background:#fff;border:1px solid var(--line);border-radius:5px}
    .search-box input{min-width:0;border:0;outline:0;font:inherit;font-size:10px;flex:1;padding:5px}
    .side-block{background:#fff;border:1px solid var(--line);border-radius:5px;padding:15px}
    .side-block h3{font-size:12px;margin:0 0 10px}
    .side-block ul{list-style:none;padding:0;margin:0}
    .side-block li{border-top:1px solid #edf0f5;padding:10px 0;font-size:10px;display:flex;justify-content:space-between}
    .side-block li b{background:var(--blue);color:#fff;border-radius:50%;font-size:8px;width:15px;height:15px;text-align:center;padding-top:3px;display:inline-block}
    .popular{display:grid;gap:11px}
    .pop{display:grid;grid-template-columns:50px 1fr;gap:9px;align-items:center}
    .pop img{width:50px;height:39px;object-fit:cover;border-radius:3px}
    .pop strong{font-size:10px;line-height:1.25;display:block}
    .pop small{font-size:8px;color:#748096;display:block;margin-top:3px}

    /* ── Pagination ── */
    .pagination-wrap{display:flex;gap:6px;justify-content:center;margin-top:24px;flex-wrap:wrap}
    .pagination-wrap a,.pagination-wrap span{font-size:11px;padding:6px 11px;border:1px solid var(--line);border-radius:3px;background:#fff;color:#536078}
    .pagination-wrap .active span,.pagination-wrap span[aria-current]{background:var(--blue);color:#fff;border-color:var(--blue)}

    /* ── Filters ── */
    .filters{display:flex;gap:9px;margin:16px 0;flex-wrap:wrap}
    .filters select,.filters input{border:1px solid var(--line);font-size:10px;padding:8px;background:white;color:#536078;font-family:inherit;border-radius:3px}
    .filters input{min-width:0;flex:1}

    /* ── Alert / Flash ── */
    .alert{padding:12px 16px;border-radius:4px;margin-bottom:16px;font-size:12px}
    .alert-success{background:#e8f5e9;border:1px solid #a5d6a7;color:#2e7d32}
    .alert-error{background:#ffebee;border:1px solid #ef9a9a;color:#c62828}

    /* ── Status Badge ── */
    .badge{display:inline-block;font-size:8px;padding:3px 7px;border-radius:10px;font-weight:600}
    .badge-published{background:#e8f5e9;color:#2e7d32}
    .badge-draft{background:#fff3e0;color:#e65100}
    .badge-berjalan{background:#e3f2fd;color:#1565c0}
    .badge-selesai{background:#e8f5e9;color:#2e7d32}

    /* ── Footer ── */
    footer{text-align:center;color:#71809b;font-size:10px;padding:30px;background:#fff;border-top:1px solid var(--line)}
    footer a{color:var(--blue)}

    /* ── Content Grid ── */
    .content-grid{max-width:1180px;margin:18px auto 52px;padding:0 18px;display:grid;grid-template-columns:1fr 280px;gap:28px}

    /* ── Responsive ── */
    @media(max-width:760px){
      .site-header{height:62px;padding:0 16px}
      .menu-button{display:block}
      nav{display:none;position:absolute;top:62px;left:0;right:0;background:#fff;border-bottom:1px solid var(--line);flex-direction:column;padding:12px 16px;gap:0;z-index:99}
      nav.open{display:flex}
      nav a{padding:10px 0;border-bottom:1px solid var(--line);font-size:13px}
      .content-grid{grid-template-columns:1fr;padding:0 12px;gap:16px}
      .cards{grid-template-columns:repeat(2,1fr)}
      .section-pad{margin:0 12px 25px;padding:25px 14px}
      .filters{flex-wrap:wrap}
      .list-item{grid-template-columns:90px 1fr}
      .list-item img{width:90px;height:90px}
      /* Sidebar tampil di bawah main content */
      .sidebar{width:100%;gap:12px}
      .side-block{padding:12px}
      .side-block h3{font-size:13px}
      .side-block li{font-size:11px}
      .search-box input{font-size:12px}
      /* Hoax block lebih readable di mobile */
      .hoax-block{padding:12px}
      .hoax-header h3{font-size:13px}
    }
  </style>
</head>
<body>
  <header class="site-header">
    <a class="brand" href="{{ route('home') }}">
      <img src="{{ asset('images/logo.jpg') }}" alt="Logo KKN 59" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0">
      <span>{{ \App\Models\SiteSetting::get('site_name', 'Pojok Informasi') }}<small>{{ \App\Models\SiteSetting::get('site_tagline', 'Informasi Aktual, Inspiratif, dan Bermanfaat') }}</small></span>
    </a>
    <button class="menu-button" id="menuBtn" aria-label="Buka menu">☰</button>
    <nav id="mainNav">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? 'active' : '' }}">Artikel</a>
      <a href="{{ route('work-programs.index') }}" class="{{ request()->routeIs('work-programs.*') ? 'active' : '' }}">Program Kerja</a>
      <a href="{{ route('vision-mission') }}" class="{{ request()->routeIs('vision-mission') ? 'active' : '' }}">Visi & Misi</a>
      <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact*') ? 'active' : '' }}">Kontak</a>
      @auth
        <a href="{{ route('admin.dashboard') }}">⚙ Admin</a>
      @endauth
    </nav>
  </header>

  <main>
    @yield('content')
  </main>

  <footer id="footer">
    <p>© {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'Pojok Informasi') }} · Dibuat untuk berbagi informasi yang bermanfaat.</p>
    <p style="margin-top:6px">
      @php
        $ig = \App\Models\SiteSetting::get('instagram');
        $tt = \App\Models\SiteSetting::get('tiktok');
      @endphp
      @if($ig) <a href="{{ $ig }}" target="_blank">Instagram</a> &nbsp; @endif
      @if($tt) <a href="{{ $tt }}" target="_blank">TikTok</a> @endif
    </p>
  </footer>

  <script>
    document.getElementById('menuBtn').addEventListener('click', function() {
      document.getElementById('mainNav').classList.toggle('open');
    });
  </script>
</body>
</html>
