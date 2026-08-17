@extends('layouts.admin')

@section('title', 'Pesan Masuk')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Pesan Masuk Form Kontak</h1>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Pengirim</th>
            <th>Email</th>
            <th>Subjek</th>
            <th>Pesan</th>
            <th>Tanggal Kirim</th>
            <th>Status</th>
            <th style="width:140px;text-align:right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($messages as $msg)
            <tr style="{{ !$msg->is_read ? 'background:#fffbeb;font-weight:600' : '' }}">
              <td>{{ $msg->name }}</td>
              <td><a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></td>
              <td>{{ $msg->subject }}</td>
              <td><small style="color:#555">{{ Str::limit($msg->message, 60) }}</small></td>
              <td>{{ $msg->created_at->format('d/m/Y H:i') }}</td>
              <td>
                @if(!$msg->is_read)
                  <span class="badge badge-unread">Baru (Belum Dibaca)</span>
                @else
                  <span class="badge" style="background:#f1f5f9;color:#64748b">Sudah Dibaca</span>
                @endif
              </td>
              <td>
                <div class="table-actions" style="justify-content:flex-end">
                  @if(!$msg->is_read)
                    <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn btn-secondary btn-sm" title="Tandai Sudah Dibaca">✓</button>
                    </form>
                  @endif
                  <button type="button" onclick="alert('Pesan Lengkap dari {{ $msg->name }}:\n\n{{ addslashes($msg->message) }}')" class="btn btn-secondary btn-sm">Lihat</button>
                  <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="text-align:center;color:#888;padding:24px">Belum ada pesan masuk dari pengunjung.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:16px">
      {{ $messages->links() }}
    </div>
  </div>
@endsection
