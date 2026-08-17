@extends('layouts.public')

@section('title', 'Daftar Artikel')

@section('content')
  <section class="section-pad listing">
    <p class="eyebrow"><a href="{{ route('home') }}">Beranda</a> / Artikel</p>
    <h2>Daftar Artikel</h2>

    <form class="filters" method="GET" action="{{ route('articles.index') }}">
      <select name="kategori" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
          <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
      <input name="q" placeholder="Cari artikel..." value="{{ request('q') }}" />
      <button type="submit" class="primary">Cari</button>
      @if(request('kategori') || request('q'))
        <a href="{{ route('articles.index') }}" class="btn-outline" style="font-size:10px;padding:8px 12px">Reset</a>
      @endif
    </form>

    <div style="display:grid;grid-template-columns:1fr 260px;gap:28px" class="content-grid-wrap">
      <div class="article-list" style="max-width:100%">
        @forelse($articles as $art)
          <article class="list-item">
            <img src="{{ $art->thumbnail_url }}" alt="{{ $art->title }}">
            <div>
              <span class="category">{{ strtoupper($art->category) }}</span>
              <h3><a href="{{ route('articles.show', $art->slug) }}">{{ $art->title }}</a></h3>
              <p>{{ Str::limit(strip_tags($art->content), 110) }}</p>
              <div class="byline dark">
                <span class="avatar">{{ strtoupper(substr($art->user->name ?? 'A', 0, 1)) }}</span>
                {{ $art->user->name ?? 'Admin' }} <i>•</i> {{ $art->created_at->translatedFormat('d M Y') }}
                <a href="{{ route('articles.show', $art->slug) }}" style="margin-left:auto">Baca Selengkapnya →</a>
              </div>
            </div>
          </article>
        @empty
          <p style="font-size:12px;color:#777">Tidak ada artikel yang ditemukan.</p>
        @endforelse

        <div class="pagination-wrap">
          {{ $articles->links() }}
        </div>
      </div>

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
          <h3>Artikel Populer</h3>
          <div class="popular">
            @foreach($popular as $pop)
              <div class="pop">
                <img src="{{ $pop->thumbnail_url }}" alt="">
                <div>
                  <strong><a href="{{ route('articles.show', $pop->slug) }}">{{ Str::limit($pop->title, 35) }}</a></strong>
                  <small>◷ {{ $pop->created_at->format('d M Y') }}</small>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </aside>
    </div>
  </section>
@endsection
