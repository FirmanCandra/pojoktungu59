@extends('layouts.public')

@section('title', 'Program Kerja')

@section('content')
  <section class="section-pad">
    <p class="eyebrow"><a href="{{ route('home') }}">Beranda</a> / Program Kerja</p>
    <h2>Program Kerja</h2>
    <p style="font-size:12px;color:var(--muted);margin-bottom:20px">Daftar agenda dan program kerja organisasi yang sedang berjalan maupun telah selesai dilaksanakan.</p>

    <!-- Filter Status + Kategori -->
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px;align-items:center">
      <!-- Status Filter -->
      <div style="display:flex;gap:0;border-radius:4px;overflow:hidden;border:1px solid var(--line)">
        <a href="{{ route('work-programs.index', array_merge(request()->except('status'), [])) }}"
           style="font-size:10px;padding:7px 14px;background:{{ !request('status') ? 'var(--blue)' : '#fff' }};color:{{ !request('status') ? '#fff' : '#536078' }}">
          Semua
        </a>
        <a href="{{ route('work-programs.index', array_merge(request()->except('status'), ['status' => 'berjalan'])) }}"
           style="font-size:10px;padding:7px 14px;background:{{ request('status') == 'berjalan' ? 'var(--blue)' : '#fff' }};color:{{ request('status') == 'berjalan' ? '#fff' : '#536078' }};border-left:1px solid var(--line)">
          Sedang Berjalan
        </a>
        <a href="{{ route('work-programs.index', array_merge(request()->except('status'), ['status' => 'selesai'])) }}"
           style="font-size:10px;padding:7px 14px;background:{{ request('status') == 'selesai' ? 'var(--blue)' : '#fff' }};color:{{ request('status') == 'selesai' ? '#fff' : '#536078' }};border-left:1px solid var(--line)">
          Selesai
        </a>
      </div>

      <!-- Kategori Filter -->
      <form method="GET" action="{{ route('work-programs.index') }}" style="display:flex;gap:8px;align-items:center">
        @if(request('status'))
          <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <select name="kategori" onchange="this.form.submit()" style="font-size:10px;padding:7px 10px;border:1px solid var(--line);border-radius:4px;background:#fff;color:#536078;font-family:inherit">
          <option value="">Semua Bidang</option>
          @foreach(config('categories.work_program') as $cat)
            <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>
        @if(request('kategori') || request('status'))
          <a href="{{ route('work-programs.index') }}" style="font-size:10px;color:var(--blue)">Reset</a>
        @endif
      </form>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:20px">
      @forelse($workPrograms as $prog)
        <div style="background:#fff;border:1px solid var(--line);border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.03);transition:transform .2s,box-shadow .2s" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(20,91,215,.08)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(0,0,0,.03)'">
          <div style="height:160px;background-size:cover;background-position:center;background-image:url('{{ $prog->image_url }}')"></div>
          <div style="padding:16px">
            <div style="display:flex;gap:6px;margin-bottom:8px;flex-wrap:wrap">
              <span class="badge badge-{{ $prog->status }}">{{ strtoupper($prog->status) }}</span>
              @if($prog->category)
                <span class="badge" style="background:#f0f4ff;color:var(--blue)">{{ $prog->category }}</span>
              @endif
            </div>
            <h3 style="font-size:14px;margin:0 0 6px"><a href="{{ route('work-programs.show', $prog->slug) }}">{{ $prog->title }}</a></h3>
            <p style="font-size:11px;color:var(--muted);line-height:1.4;margin-bottom:10px">{{ Str::limit(strip_tags($prog->description), 90) }}</p>
            <div style="font-size:10px;color:#888;border-top:1px solid #f0f0f0;padding-top:8px">
              📅 {{ $prog->start_date ? $prog->start_date->format('d M Y') : 'TBA' }}
              @if($prog->end_date) — {{ $prog->end_date->format('d M Y') }} @endif
            </div>
          </div>
        </div>
      @empty
        <p style="grid-column:1/-1;font-size:12px;color:#777;padding:24px;text-align:center">Tidak ada program kerja dalam kategori / filter ini.</p>
      @endforelse
    </div>

    <div class="pagination-wrap" style="margin-top:30px">
      {{ $workPrograms->links() }}
    </div>
  </section>
@endsection
