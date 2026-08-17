@extends('layouts.admin')

@section('title', 'Kelola Artikel')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Kelola Artikel</h1>
    <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">+ Tambah Artikel Baru</a>
  </div>

  <div class="panel">
    <div class="toolbar">
      <div class="toolbar-tabs">
        <a href="{{ route('admin.artikel.index') }}" class="{{ !request('status') ? 'active' : '' }}">Semua</a>
        <a href="{{ route('admin.artikel.index', ['status' => 'published']) }}" class="{{ request('status') == 'published' ? 'active' : '' }}">Terbit</a>
        <a href="{{ route('admin.artikel.index', ['status' => 'draft']) }}" class="{{ request('status') == 'draft' ? 'active' : '' }}">Draft</a>
      </div>

      <form class="toolbar-right" method="GET" action="{{ route('admin.artikel.index') }}">
        @if(request('status'))
          <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul artikel..." class="form-control" style="width:200px;padding:5px 10px;font-size:10px">
        <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
      </form>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:50px">Gambar</th>
            <th>Judul Artikel</th>
            <th>Kategori</th>
            <th>Penulis</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th style="width:120px;text-align:right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($articles as $art)
            <tr>
              <td>
                <img src="{{ $art->thumbnail_url }}" alt="" class="img-current">
              </td>
              <td>
                <a href="{{ route('admin.artikel.edit', $art->id) }}" style="font-weight:600;color:var(--ink)">{{ $art->title }}</a>
                <small style="display:block;color:#888">slug: {{ $art->slug }}</small>
              </td>
              <td><span class="badge" style="background:#f1f5f9;color:#475569">{{ $art->category }}</span></td>
              <td>{{ $art->user->name ?? 'Admin' }}</td>
              <td>{{ $art->created_at->format('d/m/Y') }}</td>
              <td><span class="badge badge-{{ $art->status }}">{{ strtoupper($art->status) }}</span></td>
              <td>
                <div class="table-actions" style="justify-content:flex-end">
                  <a href="{{ route('articles.show', $art->slug) }}" target="_blank" class="btn btn-secondary btn-sm" title="Pratinjau">👁</a>
                  <a href="{{ route('admin.artikel.edit', $art->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                  <form action="{{ route('admin.artikel.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="text-align:center;color:#888;padding:24px">Belum ada artikel. Klik "Tambah Artikel Baru" untuk membuat artikel pertama.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:16px">
      {{ $articles->links() }}
    </div>
  </div>
@endsection
