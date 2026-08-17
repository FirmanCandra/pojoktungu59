@extends('layouts.admin')

@section('title', 'Dashboard')

@section('admin-content')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <style>
    .live-pulse {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(22, 163, 74, 0.1);
      color: #15803d;
      font-size: 10px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 12px;
      border: 1px solid rgba(22, 163, 74, 0.2);
    }
    .pulse-dot {
      width: 7px;
      height: 7px;
      background-color: #22c55e;
      border-radius: 50%;
      box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
      animation: pulse 1.6s infinite;
    }
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
      70% { box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
      100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    .stat-card-visitor {
      background: linear-gradient(135deg, #145bd7 0%, #2575fc 100%);
      color: #fff;
      border-radius: 8px;
      padding: 18px 20px;
      display: flex;
      flex-direction: column;
      gap: 4px;
      box-shadow: 0 6px 20px rgba(20, 91, 215, 0.2);
    }
    .stat-card-visitor small { opacity: .8; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
    .stat-card-visitor strong { font-size: 32px; font-weight: 700; line-height: 1; }
    .stat-card-visitor span { font-size: 10px; opacity: .75; }
    .visitor-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-bottom: 20px;
    }
  </style>

  <div class="admin-topbar">
    <div>
      <h1>Dashboard Overview</h1>
      <small style="color:#64748b;font-size:11px">Ringkasan data real-time aktivitas website</small>
    </div>
    <div style="display:flex;align-items:center;gap:14px">
      <div class="live-pulse">
        <span class="pulse-dot"></span> REAL-TIME <span id="lastUpdated" style="opacity:.85">({{ now()->format('H:i:s') }})</span>
      </div>
      <div class="user-info">
        <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        Hai, <strong>{{ auth()->user()->name }}</strong> 👤
      </div>
    </div>
  </div>

  <!-- Visitor Cards -->
  <div class="visitor-grid">
    <div class="stat-card-visitor">
      <small>👥 Total Pengunjung Unik</small>
      <strong id="statTotalVisitors">{{ $totalVisitors }}</strong>
      <span>Semua waktu (IP unik)</span>
    </div>
    <div class="stat-card-visitor" style="background:linear-gradient(135deg,#0f766e 0%,#14b8a6 100%);box-shadow:0 6px 20px rgba(15,118,110,.2)">
      <small>📅 Pengunjung Hari Ini</small>
      <strong id="statTodayVisitors">{{ $todayVisitors }}</strong>
      <span>{{ now()->format('d M Y') }}</span>
    </div>
  </div>

  <!-- Real-Time Stat Cards -->
  <div class="stat-grid">
    <div class="stat-card">
      <small>Total Artikel</small>
      <strong id="statTotalArticles">{{ $totalArticles }}</strong>
      <span><span id="statPublishedArticles">{{ $publishedArticles }}</span> terbit • <span id="statDraftArticles">{{ $draftArticles }}</span> draft</span>
    </div>

    <div class="stat-card">
      <small>Program Kerja</small>
      <strong id="statTotalPrograms">{{ $totalPrograms }}</strong>
      <span><span id="statRunningPrograms">{{ $runningPrograms }}</span> berjalan • <span id="statCompletedPrograms">{{ $completedPrograms }}</span> selesai</span>
    </div>

    <div class="stat-card">
      <small>Pesan Masuk</small>
      <strong id="statUnreadMessages" style="color:{{ $unreadMessages > 0 ? '#dc2626' : 'inherit' }}">{{ $unreadMessages }}</strong>
      <span>Pesan belum dibaca</span>
    </div>

    <div class="stat-card">
      <small>Status Server / Admin</small>
      <strong style="font-size:18px;color:#15803d">Online ⚡</strong>
      <span>Role: Administrator</span>
    </div>
  </div>

  <!-- Chart Grid -->
  <div class="panel-grid">
    <div class="panel">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid var(--line)">
        <div class="panel-title" style="margin:0;border:0;padding:0">Pengunjung 7 Hari Terakhir</div>
        <span style="font-size:9px;color:#64748b">Update otomatis</span>
      </div>
      <div style="position:relative;height:200px;width:100%">
        <canvas id="visitorChart"></canvas>
      </div>
    </div>

    <div class="panel">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid var(--line)">
        <div class="panel-title" style="margin:0;border:0;padding:0">Statistik Artikel & Pesan (6 Bln)</div>
        <span style="font-size:9px;color:#64748b">Grafik bulanan</span>
      </div>
      <div style="position:relative;height:200px;width:100%">
        <canvas id="realtimeChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Recent Articles Panel -->
  <div class="panel" style="margin-top:0">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid var(--line)">
      <div class="panel-title" style="margin:0;border:0;padding:0">Artikel Terbaru</div>
      <span style="font-size:9px;color:#64748b">Live Sync</span>
    </div>
    <div id="recentArticlesList" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:10px">
      @forelse($recentArticles as $art)
        <div style="font-size:11px;padding:10px;border:1px solid var(--line);border-radius:6px">
          <a href="{{ route('admin.artikel.edit', $art->id) }}" style="font-weight:600;display:block;color:var(--ink);margin-bottom:4px">{{ Str::limit($art->title, 35) }}</a>
          <small style="color:#758098">{{ $art->created_at->format('d M Y') }} • <span class="badge badge-{{ $art->status }}">{{ strtoupper($art->status) }}</span></small>
        </div>
      @empty
        <p style="font-size:11px;color:#888">Belum ada artikel.</p>
      @endforelse
    </div>
    <a href="{{ route('admin.artikel.index') }}" style="font-size:10px;display:inline-block;margin-top:12px;font-weight:600">Lihat semua artikel →</a>
  </div>

  <!-- Real-Time Polling Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // ── Visitor 7-day Chart ──
      const visitorCtx = document.getElementById('visitorChart').getContext('2d');
      const visitorChart = new Chart(visitorCtx, {
        type: 'bar',
        data: {
          labels: @json($visitorLabels),
          datasets: [{
            label: 'Pengunjung Unik',
            data: @json($visitorCounts),
            backgroundColor: 'rgba(20,91,215,0.75)',
            borderRadius: 5,
            borderSkipped: false,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          },
          scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, font: { family: 'DM Sans', size: 10 } }, grid: { color: '#f1f5f9' } },
            x: { ticks: { font: { family: 'DM Sans', size: 10 } }, grid: { display: false } }
          }
        }
      });

      // ── Article & Message Monthly Chart ──
      const ctx = document.getElementById('realtimeChart').getContext('2d');
      const chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: @json($chartLabels),
          datasets: [
            {
              label: 'Artikel Terbit',
              data: @json($chartArticles),
              borderColor: '#145bd7',
              backgroundColor: 'rgba(20,91,215,0.08)',
              borderWidth: 2.5,
              tension: 0.35,
              fill: true,
              pointBackgroundColor: '#145bd7',
              pointRadius: 4
            },
            {
              label: 'Pesan Masuk',
              data: @json($chartMessages),
              borderColor: '#16a34a',
              backgroundColor: 'rgba(22,163,74,0.06)',
              borderWidth: 2,
              borderDash: [4,4],
              tension: 0.35,
              fill: false,
              pointBackgroundColor: '#16a34a',
              pointRadius: 3
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'top', labels: { font: { family: 'DM Sans', size: 10 }, boxWidth: 12 } }
          },
          scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, font: { family: 'DM Sans', size: 10 } }, grid: { color: '#f1f5f9' } },
            x: { ticks: { font: { family: 'DM Sans', size: 10 } }, grid: { display: false } }
          }
        }
      });

      // ── Live Polling every 5 seconds ──
      function fetchRealtimeStats() {
        fetch('{{ route("admin.stats-api") }}')
          .then(res => res.json())
          .then(data => {
            // Visitor cards
            document.getElementById('statTotalVisitors').textContent = data.totalVisitors;
            document.getElementById('statTodayVisitors').textContent = data.todayVisitors;

            // Stat cards
            document.getElementById('statTotalArticles').textContent     = data.totalArticles;
            document.getElementById('statPublishedArticles').textContent = data.publishedArticles;
            document.getElementById('statDraftArticles').textContent     = data.draftArticles;
            document.getElementById('statTotalPrograms').textContent     = data.totalPrograms;
            document.getElementById('statRunningPrograms').textContent   = data.runningPrograms;
            document.getElementById('statCompletedPrograms').textContent = data.completedPrograms;
            const msgEl = document.getElementById('statUnreadMessages');
            msgEl.textContent  = data.unreadMessages;
            msgEl.style.color  = data.unreadMessages > 0 ? '#dc2626' : 'inherit';

            // Timestamp
            document.getElementById('lastUpdated').textContent = '(' + data.timestamp + ')';

            // Update visitor chart
            visitorChart.data.labels        = data.visitorLabels;
            visitorChart.data.datasets[0].data = data.visitorCounts;
            visitorChart.update('none');

            // Update article/message chart
            chart.data.labels              = data.chartLabels;
            chart.data.datasets[0].data   = data.chartArticles;
            chart.data.datasets[1].data   = data.chartMessages;
            chart.update('none');

            // Update recent articles list
            if (data.recent_articles && data.recent_articles.length > 0) {
              document.getElementById('recentArticlesList').innerHTML =
                data.recent_articles.map(art => `
                  <div style="font-size:11px;padding:10px;border:1px solid var(--line);border-radius:6px">
                    <a href="${art.edit_url}" style="font-weight:600;display:block;color:var(--ink);margin-bottom:4px">${art.title}</a>
                    <small style="color:#758098">${art.date} • <span class="badge badge-${art.status}">${art.status_str}</span></small>
                  </div>
                `).join('');
            }
          })
          .catch(err => console.log('Realtime sync error:', err));
      }

      setInterval(fetchRealtimeStats, 5000);
    });
  </script>
@endsection
