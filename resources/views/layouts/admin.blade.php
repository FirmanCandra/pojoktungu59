<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard') — Admin Pojok Informasi</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    :root{--blue:#145bd7;--ink:#13213d;--muted:#63708a;--line:#e4eaf3;--bg:#f4f7fb;--sidebar:#10223a;--sidebar-hover:#1a3455;--sidebar-active:#1661dd}
    *{box-sizing:border-box}
    body{margin:0;font-family:'DM Sans',sans-serif;color:var(--ink);background:var(--bg)}
    a{color:var(--blue);text-decoration:none;cursor:pointer}
    button{font:inherit;cursor:pointer;border:0}
    input,select,textarea{font-family:inherit}

    /* ── Admin Shell ── */
    .admin-shell{display:grid;grid-template-columns:190px 1fr;min-height:100vh}

    /* ── Sidebar ── */
    .admin-sidebar{background:var(--sidebar);color:#eaf2ff;display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
    .sidebar-brand{display:flex;align-items:center;gap:8px;color:#fff;font-weight:700;font-size:14px;padding:20px 16px 14px;border-bottom:1px solid rgba(255,255,255,.08);white-space:nowrap}
    .brand-mark{background:var(--blue);color:#fff;border-radius:50%;width:26px;height:26px;display:grid;place-items:center;font-size:14px;flex-shrink:0}
    .sidebar-brand small{display:block;font-size:8px;color:#8baed4;font-weight:400}
    .sidebar-nav{padding:10px 0;flex:1}
    .sidebar-nav a{display:flex;align-items:center;gap:9px;color:#c8ddf5;font-size:11px;padding:11px 18px;transition:background .15s,color .15s}
    .sidebar-nav a:hover{background:var(--sidebar-hover);color:#fff}
    .sidebar-nav a.active{background:var(--sidebar-active);color:#fff;font-weight:600}
    .sidebar-nav .nav-icon{width:14px;text-align:center}
    .sidebar-nav .badge-count{margin-left:auto;background:#ed4d5a;border-radius:8px;padding:1px 6px;font-size:8px;font-weight:700}
    .sidebar-footer{padding:14px 18px;border-top:1px solid rgba(255,255,255,.08)}
    .sidebar-footer a{color:#8baed4;font-size:10px}
    .sidebar-footer a:hover{color:#fff}

    /* ── Admin Main ── */
    .admin-main{min-width:0;padding:24px 28px;max-width:1100px}
    .admin-topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
    .admin-topbar h1{font-size:20px;margin:0}
    .admin-topbar .user-info{font-size:11px;color:#65718a;display:flex;align-items:center;gap:8px}
    .admin-topbar .user-avatar{width:28px;height:28px;border-radius:50%;background:#efbc88;color:#542b0c;display:grid;place-items:center;font-size:11px;font-weight:700}

    /* ── Stat Cards ── */
    .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:13px;margin-bottom:24px}
    .stat-card{background:#fff;border:1px solid var(--line);border-radius:6px;padding:16px;position:relative;overflow:hidden}
    .stat-card::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:var(--blue)}
    .stat-card small{display:block;color:#758098;font-size:9px;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px}
    .stat-card strong{display:block;font-size:26px;font-weight:700;color:var(--ink)}
    .stat-card span{display:block;font-size:9px;color:#758098;margin-top:4px}

    /* ── Cards / Panels ── */
    .panel{background:#fff;border:1px solid var(--line);border-radius:6px;padding:18px;margin-bottom:18px}
    .panel-title{font-size:13px;font-weight:600;margin:0 0 14px;padding-bottom:10px;border-bottom:1px solid var(--line)}
    .panel-grid{display:grid;grid-template-columns:2fr 1fr;gap:16px}

    /* ── Table ── */
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:11px}
    th{text-align:left;background:#f5f7fa;color:#5d6980;padding:10px 10px;border-bottom:2px solid var(--line);white-space:nowrap;font-size:10px;text-transform:uppercase;letter-spacing:.3px}
    td{padding:11px 10px;border-bottom:1px solid var(--line);vertical-align:middle}
    tr:hover td{background:#fafbff}
    .table-actions{display:flex;gap:8px;align-items:center}

    /* ── Buttons ── */
    .btn{font:inherit;cursor:pointer;border-radius:3px;padding:7px 14px;font-size:11px;border:none;transition:background .2s,opacity .2s}
    .btn-primary{background:var(--blue);color:#fff}
    .btn-primary:hover{background:#0f4bb8}
    .btn-secondary{background:#fff;border:1px solid var(--line);color:var(--ink)}
    .btn-secondary:hover{background:#f5f7fa}
    .btn-danger{background:#fff;border:1px solid #fca5a5;color:#dc2626;font-size:10px}
    .btn-danger:hover{background:#fef2f2}
    .btn-sm{padding:4px 10px;font-size:10px}
    .btn-success{background:#15803d;color:#fff}

    /* ── Form ── */
    .form-group{margin-bottom:16px}
    .form-group label{display:block;font-size:11px;font-weight:600;margin-bottom:5px;color:#46536b}
    .form-control{width:100%;padding:9px 12px;border:1px solid var(--line);border-radius:4px;font:inherit;font-size:12px;color:var(--ink);background:#fff;transition:border-color .2s}
    .form-control:focus{outline:none;border-color:var(--blue);box-shadow:0 0 0 3px rgba(20,91,215,.1)}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .form-text{font-size:10px;color:var(--muted);margin-top:4px}
    .form-error{font-size:10px;color:#dc2626;margin-top:4px}
    textarea.form-control{resize:vertical;min-height:150px}

    /* ── Toolbar ── */
    .toolbar{display:flex;gap:10px;align-items:center;margin-bottom:16px;flex-wrap:wrap}
    .toolbar-tabs{display:flex;gap:0}
    .toolbar-tabs a{font-size:10px;padding:6px 12px;border:1px solid var(--line);color:#536078;background:#fff}
    .toolbar-tabs a:first-child{border-radius:3px 0 0 3px}
    .toolbar-tabs a:last-child{border-radius:0 3px 3px 0}
    .toolbar-tabs a.active{background:var(--blue);color:#fff;border-color:var(--blue)}
    .toolbar-right{margin-left:auto;display:flex;gap:8px}

    /* ── Badge ── */
    .badge{display:inline-block;font-size:8px;padding:3px 7px;border-radius:10px;font-weight:600}
    .badge-published,.badge-selesai{background:#dcfce7;color:#15803d}
    .badge-draft{background:#fef3c7;color:#b45309}
    .badge-berjalan{background:#dbeafe;color:#1d4ed8}
    .badge-unread{background:#fee2e2;color:#dc2626}

    /* ── Flash ── */
    .flash{padding:12px 16px;border-radius:4px;margin-bottom:16px;font-size:12px;display:flex;align-items:center;gap:8px}
    .flash-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
    .flash-error{background:#fef2f2;border:1px solid #fecaca;color:#dc2626}

    /* ── Image preview ── */
    .img-preview{width:100%;max-height:200px;object-fit:cover;border-radius:4px;margin-top:8px;display:none}
    .img-current{width:80px;height:60px;object-fit:cover;border-radius:3px}

    /* ── Responsive ── */
    @media(max-width:900px){
      .admin-shell{grid-template-columns:1fr}
      .admin-sidebar{position:static;height:auto;flex-direction:row;flex-wrap:wrap}
      .sidebar-nav{display:flex;overflow-x:auto;padding:0}
      .sidebar-nav a{white-space:nowrap;padding:10px 14px}
      .sidebar-footer{display:none}
      .stat-grid{grid-template-columns:repeat(2,1fr)}
      .panel-grid{grid-template-columns:1fr}
      .form-row{grid-template-columns:1fr}
      .admin-main{padding:16px}
    }
  </style>
</head>
<body>
  <div class="admin-shell">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
      <a class="sidebar-brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo KKN 59" style="width:30px;height:30px;border-radius:50%;object-fit:cover;flex-shrink:0">
        <span>Pojok Informasi<small>Admin Panel</small></span>
      </a>
      <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <span class="nav-icon">⌂</span> Dashboard
        </a>
        <a href="{{ route('admin.artikel.index') }}" class="{{ request()->routeIs('admin.artikel*') ? 'active' : '' }}">
          <span class="nav-icon">▱</span> Artikel
        </a>
        <a href="{{ route('admin.program-kerja.index') }}" class="{{ request()->routeIs('admin.program-kerja*') ? 'active' : '' }}">
          <span class="nav-icon">▣</span> Program Kerja
        </a>
        <a href="{{ route('admin.vision-mission.edit') }}" class="{{ request()->routeIs('admin.vision-mission*') ? 'active' : '' }}">
          <span class="nav-icon">◎</span> Visi & Misi
        </a>
        <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
          <span class="nav-icon">✉</span> Pesan
          @php $unread = \App\Models\ContactMessage::unread()->count(); @endphp
          @if($unread > 0)
            <span class="badge-count">{{ $unread }}</span>
          @endif
        </a>
        <a href="{{ route('admin.pengumuman.index') }}" class="{{ request()->routeIs('admin.pengumuman*') ? 'active' : '' }}">
          <span class="nav-icon">📢</span> Pengumuman
        </a>
        <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
          <span class="nav-icon">⚙</span> Pengaturan
        </a>
      </nav>
      <div class="sidebar-footer">
        <a href="{{ route('home') }}" target="_blank">← Lihat Website</a><br><br>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background:none;border:none;color:#8baed4;font-size:10px;cursor:pointer;padding:0;font-family:inherit">
            ⏻ Logout ({{ auth()->user()->name }})
          </button>
        </form>
      </div>
    </aside>

    <!-- Main -->
    <div class="admin-main">
      @if(session('success'))
        <div class="flash flash-success">✓ {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="flash flash-error">✗ {{ session('error') }}</div>
      @endif
      @yield('admin-content')
    </div>
  </div>
</body>
</html>
