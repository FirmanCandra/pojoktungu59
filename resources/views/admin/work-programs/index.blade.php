@extends('layouts.admin')

@section('title', 'Kelola Program Kerja')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Kelola Program Kerja</h1>
    <a href="{{ route('admin.program-kerja.create') }}" class="btn btn-primary">+ Tambah Program Kerja</a>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:60px">Gambar</th>
            <th>Judul Program Kerja</th>
            <th>Bidang</th>
            <th>Status</th>
            <th>Tanggal Pelaksanaan</th>
            <th>Dibuat Pada</th>
            <th style="width:120px;text-align:right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($workPrograms as $prog)
            <tr>
              <td><img src="{{ $prog->image_url }}" alt="" class="img-current"></td>
              <td>
                <a href="{{ route('admin.program-kerja.edit', $prog->id) }}" style="font-weight:600;color:var(--ink)">{{ $prog->title }}</a>
                <small style="display:block;color:#888">{{ Str::limit(strip_tags($prog->description), 50) }}</small>
              </td>
              <td>{{ $prog->category ?: '-' }}</td>
              <td><span class="badge badge-{{ $prog->status }}">{{ strtoupper($prog->status) }}</span></td>
              <td>
                {{ $prog->start_date ? $prog->start_date->format('d/m/Y') : '-' }}
                @if($prog->end_date) s/d {{ $prog->end_date->format('d/m/Y') }} @endif
              </td>
              <td>{{ $prog->created_at->format('d/m/Y') }}</td>
              <td>
                <div class="table-actions" style="justify-content:flex-end">
                  <a href="{{ route('work-programs.show', $prog->slug) }}" target="_blank" class="btn btn-secondary btn-sm" title="Pratinjau">👁</a>
                  <a href="{{ route('admin.program-kerja.edit', $prog->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                  <form action="{{ route('admin.program-kerja.destroy', $prog->id) }}" method="POST" onsubmit="return confirm('Hapus program kerja ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center;color:#888;padding:24px">Belum ada program kerja.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:16px">
      {{ $workPrograms->links() }}
    </div>
  </div>
@endsection
