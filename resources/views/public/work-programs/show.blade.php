@extends('layouts.public')

@section('title', $program->title)

@section('content')
  <section class="section-pad">
    <p class="eyebrow"><a href="{{ route('home') }}">Beranda</a> / <a href="{{ route('work-programs.index') }}">Program Kerja</a> / {{ Str::limit($program->title, 30) }}</p>

    <div style="max-width:800px;margin:0 auto">
      <div style="display:flex;gap:8px;margin-bottom:10px;flex-wrap:wrap">
        <span class="badge badge-{{ $program->status }}" style="font-size:10px;padding:4px 10px">{{ strtoupper($program->status) }}</span>
        @if($program->category)
          <span class="badge" style="background:#f0f4ff;color:var(--blue);font-size:10px;padding:4px 10px">{{ $program->category }}</span>
        @endif
      </div>
      <h1 style="font-size:26px;margin:12px 0 14px;line-height:1.3">{{ $program->title }}</h1>
      
      <div style="font-size:11px;color:#666;margin-bottom:20px">
        📅 Pelaksanaan: <strong>{{ $program->start_date ? $program->start_date->translatedFormat('d F Y') : '-' }}</strong>
        @if($program->end_date) s/d <strong>{{ $program->end_date->translatedFormat('d F Y') }}</strong> @endif
      </div>

      @if($program->image)
        <img src="{{ $program->image_url }}" alt="{{ $program->title }}" style="width:100%;max-height:400px;object-fit:cover;border-radius:6px;margin-bottom:24px">
      @endif

      <div style="font-size:13px;line-height:1.8;color:#334155;white-space:pre-line">
        {!! nl2br(e($program->description)) !!}
      </div>

      <div style="margin-top:40px;padding-top:20px;border-top:1px solid var(--line)">
        <a href="{{ route('work-programs.index') }}" class="btn-outline">← Kembali ke Program Kerja</a>
      </div>
    </div>
  </section>
@endsection
