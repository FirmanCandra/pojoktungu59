@extends('layouts.public')

@section('title', 'Visi & Misi')

@section('content')
  <style>
    .vm-hero {
      background: linear-gradient(135deg, #0d1e38 0%, #145bd7 100%);
      color: #fff;
      border-radius: 12px;
      padding: 44px 28px;
      text-align: center;
      margin-bottom: 32px;
      position: relative;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(20, 91, 215, 0.12);
    }
    .vm-hero::before {
      content: '';
      position: absolute;
      top: -40%;
      right: -8%;
      width: 280px;
      height: 280px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 50%;
      pointer-events: none;
    }
    .vm-hero-badge {
      display: inline-block;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(8px);
      color: #e0edff;
      font-size: 10px;
      font-weight: 700;
      padding: 5px 14px;
      border-radius: 20px;
      margin-bottom: 12px;
      letter-spacing: 1px;
      text-transform: uppercase;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .vm-hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: 30px;
      margin: 0 0 10px;
      color: #fff;
    }
    .vm-hero p {
      font-size: 12px;
      color: #c8ddf5;
      max-width: 520px;
      margin: 0 auto;
      line-height: 1.6;
    }

    /* ── Visi Card ── */
    .visi-card {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 10px;
      padding: 30px;
      margin-bottom: 32px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
      position: relative;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .visi-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(20, 91, 215, 0.08);
    }
    .visi-header {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 16px;
    }
    .icon-box-visi {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      background: linear-gradient(135deg, #145bd7, #2575fc);
      color: #fff;
      display: grid;
      place-items: center;
      font-size: 20px;
      box-shadow: 0 4px 12px rgba(20, 91, 215, 0.25);
      flex-shrink: 0;
    }
    .visi-title {
      font-size: 18px;
      font-weight: 700;
      color: var(--ink);
      margin: 0;
      letter-spacing: 0.5px;
    }
    .visi-text {
      font-size: 14px;
      line-height: 1.8;
      color: #334155;
      margin: 0;
      font-weight: 500;
      background: #f8fafc;
      padding: 20px 24px;
      border-radius: 8px;
      border-left: 4px solid var(--blue);
    }

    /* ── Misi Cards Grid ── */
    .misi-header-section {
      margin-bottom: 18px;
    }
    .misi-header-section h2 {
      font-size: 18px;
      margin: 0 0 6px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .misi-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }
    .misi-card {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 10px;
      padding: 20px;
      display: flex;
      gap: 14px;
      align-items: flex-start;
      transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    }
    .misi-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(20, 91, 215, 0.08);
      border-color: #b8d3ff;
    }
    .misi-number {
      background: rgba(20, 91, 215, 0.08);
      color: var(--blue);
      font-weight: 700;
      font-size: 13px;
      width: 36px;
      height: 36px;
      border-radius: 8px;
      display: grid;
      place-items: center;
      flex-shrink: 0;
    }
    .misi-content {
      font-size: 12px;
      line-height: 1.65;
      color: #334155;
      margin: 0;
    }

    @media (max-width: 760px) {
      .misi-grid {
        grid-template-columns: 1fr;
      }
      .vm-hero {
        padding: 32px 18px;
      }
      .visi-card {
        padding: 20px;
      }
    }
  </style>

  <section class="section-pad">
    <p class="eyebrow"><a href="{{ route('home') }}">Beranda</a> / Visi & Misi</p>

    <!-- Hero Section -->
    <div class="vm-hero">
      <span class="vm-hero-badge">✦ PROFIL KKN</span>
      <h1>Visi & Misi Utama</h1>
      <p>Komitmen dan arah langkah kami dalam memberikan pelayanan, informasi, dan dampak nyata bagi masyarakat.</p>
    </div>

    <div style="max-width:960px;margin:0 auto">
      <!-- Visi Section -->
      <div class="visi-card">
        <div class="visi-header">
          <div class="icon-box-visi">👁</div>
          <div>
            <span style="font-size:9px;color:var(--blue);font-weight:700;text-transform:uppercase;letter-spacing:1px;display:block">Arah Masa Depan</span>
            <h2 class="visi-title">VISI</h2>
          </div>
        </div>
        <blockquote class="visi-text">
          "{{ $visionMission->vision }}"
        </blockquote>
      </div>

      <!-- Misi Section -->
      <div class="misi-header-section">
        <h2>
          <span style="width:32px;height:32px;background:#e8f5e9;color:#16a34a;border-radius:8px;display:grid;place-items:center;font-size:16px">🎯</span>
          MISI
        </h2>
        <p style="font-size:11px;color:var(--muted);margin:0 0 16px">Langkah-langkah strategis dan aksi nyata yang kami jalankan secara berkelanjutan:</p>
      </div>

      @php
        $lines = array_filter(array_map('trim', explode("\n", $visionMission->mission)));
      @endphp

      <div class="misi-grid">
        @forelse($lines as $index => $line)
          @php
            $cleanText = preg_replace('/^(\d+[\.\)]|\-|\*)\s*/', '', $line);
          @endphp
          <div class="misi-card">
            <div class="misi-number">
              {{ sprintf('%02d', $index + 1) }}
            </div>
            <p class="misi-content">
              {{ $cleanText }}
            </p>
          </div>
        @empty
          <div class="misi-card" style="grid-column: 1 / -1">
            <p class="misi-content">Misi belum diatur.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>
@endsection
