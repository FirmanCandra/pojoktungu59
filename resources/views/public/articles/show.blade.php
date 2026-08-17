@extends('layouts.public')

@section('title', $article->title)
@section('meta_description', Str::limit(strip_tags($article->content), 150))

@section('content')
  <section class="article-detail section-pad">
    <p class="eyebrow">
      <a href="{{ route('home') }}">Beranda</a> / 
      <a href="{{ route('articles.index') }}">Artikel</a> / 
      {{ Str::limit($article->title, 40) }}
    </p>

    <div class="detail-layout">
      <article>
        <span class="tag light">{{ strtoupper($article->category) }}</span>
        <h1 style="font-size:26px;margin:12px 0 10px;line-height:1.3">{{ $article->title }}</h1>
        
        <div class="byline dark" style="margin-bottom:20px">
          <span class="avatar">{{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}</span>
          Penulis: <strong>{{ $article->user->name ?? 'Admin' }}</strong> <i>•</i> 
          {{ $article->published_at ? $article->published_at->translatedFormat('d F Y') : $article->created_at->translatedFormat('d F Y') }} <i>•</i> 
          Kategori: {{ $article->category }}
        </div>

        @if($article->thumbnail)
          <div style="margin-bottom:24px">
            <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" style="width:100%;max-height:400px;object-fit:cover;border-radius:6px">
          </div>
        @endif

        <div class="article-body-content" style="font-size:13px;line-height:1.8;color:#334155;white-space:pre-line">
          {!! nl2br(e($article->content)) !!}
        </div>

        <div style="margin-top:40px;padding-top:20px;border-top:1px solid var(--line);display:flex;justify-content:space-between;align-items:center">
          <a href="{{ route('articles.index') }}" class="btn-outline">← Kembali ke Artikel</a>
          <span style="font-size:10px;color:#888">Bagikan artikel ini jika bermanfaat.</span>
        </div>
      </article>

      <aside class="sidebar compact">
        <div class="side-block">
          <h3>Kategori</h3>
          <ul>
            @foreach($categories as $cat)
              @php $count = \App\Models\Article::published()->where('category', $cat)->count(); @endphp
              <li>
                <a href="{{ route('articles.index', ['kategori' => $cat]) }}">{{ $cat }}</a>
                <b>{{ $count }}</b>
              </li>
            @endforeach
          </ul>
        </div>

        <div class="side-block">
          <h3>Artikel Terkait</h3>
          <div class="popular">
            @forelse($related as $rel)
              <div class="pop">
                <img src="{{ $rel->thumbnail_url }}" alt="">
                <div>
                  <strong><a href="{{ route('articles.show', $rel->slug) }}">{{ Str::limit($rel->title, 35) }}</a></strong>
                  <small>◷ {{ $rel->created_at->format('d M Y') }}</small>
                </div>
              </div>
            @empty
              <p style="font-size:10px;color:#888">Tidak ada artikel terkait.</p>
            @endforelse
          </div>
        </div>
      </aside>
    </div>
  </section>
@endsection
