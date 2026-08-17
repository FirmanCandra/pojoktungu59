@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Kelola Pengumuman</h1>
    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">+ Tambah Pengumuman</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="panel">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Tipe</th>
          <th>Status</th>
          <th>Dibuat</th>
          <th style="text-align:right;width:120px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($announcements as $ann)
          <tr>
            <td>
              <strong style="font-size:12px">{{ $ann->title }}</strong>
              <small style="display:block;color:#888;font-size:10px;margin-top:2px">{{ Str::limit($ann->content, 60) }}</small>
            </td>
            <td>
              <span style="font-size:10px;padding:3px 8px;border-radius:10px;background:{{ $ann->type_badge_color }}1a;color:{{ $ann->type_badge_color }};font-weight:600">
                {{ $ann->type_label }}
              </span>
            </td>
            <td>
              @if($ann->is_active)
                <span class="badge badge-published">AKTIF</span>
              @else
                <span class="badge badge-draft">NONAKTIF</span>
              @endif
            </td>
            <td style="font-size:10px;color:#888">{{ $ann->created_at->format('d M Y') }}</td>
            <td style="text-align:right">
              <a href="{{ route('admin.pengumuman.edit', $ann->id) }}" class="btn btn-secondary" style="font-size:10px;padding:5px 10px">Edit</a>
              <form action="{{ route('admin.pengumuman.destroy', $ann->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus pengumuman ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" style="font-size:10px;padding:5px 10px">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" style="text-align:center;color:#888;font-size:12px;padding:24px">Belum ada pengumuman.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="pagination-wrap" style="margin-top:16px">{{ $announcements->links() }}</div>
  </div>
@endsection
