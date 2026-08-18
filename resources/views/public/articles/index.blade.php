@extends('layouts.public')

@section('title', 'Daftar Artikel')

@section('content')
  <style>
    /* Grid wrapper artikel */
    .art-listing-grid {
      display: grid;
      grid-template-columns: 1fr 260px;
      gap: 28px;
    }

    /* List item artikel */
    .article-list .list-item {
      display: grid;
      grid-template-columns: 150px 1fr;
      gap: 14px;
      padding: 12px;
      border: 1px solid var(--line);
      border-radius: 6px;
      background: #fff;
      transition: box-shadow .2s;
    }
    .article-list .list-item:hover { box-shadow: 0 4px 16px rgba(20,91,215,.08); }
    .article-list .list-item img {
      width: 150px;
      height: 100px;
      object-fit: cover;
      border-radius: 5px;
      flex-shrink: 0;
    }
    .article-list .list-item h3 { font-size: 14px; margin: 5px 0 6px; line-height: 1.35; }
    .article-list .list-item p  { font-size: 10.5px; color: #6a758b; margin: 0 0 8px; line-height: 1.45; }
    .art-byline { display: flex; align-items: center; gap: 6px; font-size: 9.5px; color: #64718a; flex-wrap: wrap; }
    .art-byline a { margin-left: auto; font-size: 9.5px; font-weight: 700; color: var(--blue); white-space: nowrap; }

    /* Breadcrumb */
    .breadcrumb { font-size: 11px; color: #888; margin-bottom: 10px; }
    .breadcrumb a { color: var(--blue); }

    /* Mobile */
    @media (max-width: 760px) {
      .art-listing-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
      /* List item: gambar di atas, teks di bawah */
      .article-list .list-item {
        grid-template-columns: 1fr;
        gap: 0;
      }
      .article-list .list-item img {
        width: 100%;
        height: 160px;
        border-radius: 5px 5px 0 0;
        margin-bottom: 10px;
      }
      .article-list .list-item h3 { font-size: 15px; }
      .article-list .list-item p  { font-size: 12px; }
      .art-byline { font-size: 11px; }
      .art-byline a { font-size: 11px; }
      /* Filter bar */
      .filters { flex-direction: column; gap: 8px; }
      .filters select,
      .filters input,
      .filters button,
      .filters a { width: 100%; box-sizing: border-box; text-align: center; }
      /* Sidebar di bawah */
      aside.sidebar { width: 100%; }
    }
  </style>

  <section class="section-pad listing">
    <p class="breadcrumb"><a href="{{ route('home') }}">Beranda</a> / Artikel</p>
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

    <div class="art-listing-grid">
      <div class="article-list" style="display:grid;gap:12px;align-content:start">
        @forelse($articles as $art)
          <article class="list-item">
            <img src="{{ $art->thumbnail_url }}" alt="{{ $art->title }}">
            <div>
              <span class="category">{{ strtoupper($art->category) }}</span>
              <h3><a href="{{ route('articles.show', $art->slug) }}">{{ $art->title }}</a></h3>
              <p>{{ Str::limit(strip_tags($art->content), 110) }}</p>
              <div class="art-byline">
                <span class="avatar">{{ strtoupper(substr($art->user->name ?? 'A', 0, 1)) }}</span>
                {{ $art->user->name ?? 'Admin' }} <i>•</i> {{ $art->created_at->translatedFormat('d M Y') }}
                <a href="{{ route('articles.show', $art->slug) }}">Baca Selengkapnya →</a>
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

