@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('admin-content')
  <div class="admin-topbar">
    <h1>Edit Artikel: {{ Str::limit($article->title, 30) }}</h1>
    <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">← Kembali ke List</a>
  </div>

  <form action="{{ route('admin.artikel.update', $article->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 280px;gap:20px">
      <!-- Main Form -->
      <div class="panel">
        <div class="form-group">
          <label for="title">Judul Artikel *</label>
          <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required class="form-control" style="font-size:16px;font-weight:600">
          @error('title') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="content">Isi Konten Artikel *</label>
          <textarea id="content" name="content" required rows="14" class="form-control">{{ old('content', $article->content) }}</textarea>
          @error('content') <div class="form-error">{{ $message }}</div> @enderror
        </div>
      </div>

      <!-- Publish Sidebar Panel -->
      <div>
        <div class="panel">
          <div class="panel-title">Pengaturan Publikasi</div>

          <div class="form-group">
            <label for="status">Status Publikasi</label>
            <select id="status" name="status" class="form-control">
              <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft (Belum Terbit)</option>
              <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Terbitkan (Publish)</option>
            </select>
            @error('status') <div class="form-error">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="category">Kategori *</label>
            <select id="category" name="category" required class="form-control">
              <option value="">— Pilih Kategori —</option>
              @foreach(config('categories.article') as $cat)
                <option value="{{ $cat }}" {{ old('category', $article->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
              @endforeach
            </select>
            @error('category') <div class="form-error">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="thumbnail">Gambar Sampul (Thumbnail)</label>
            @if($article->thumbnail)
              <div style="margin-bottom:8px">
                <small class="form-text">Sampul saat ini:</small><br>
                <img src="{{ $article->thumbnail_url }}" alt="" style="width:100%;max-height:120px;object-fit:cover;border-radius:4px;margin-top:4px">
              </div>
            @endif
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="form-control" onchange="previewImg(this)">
            <img id="imgPreview" src="" alt="Preview" class="img-preview">
            <small class="form-text">Pilih gambar baru jika ingin mengganti.</small>
            @error('thumbnail') <div class="form-error">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="published_at">Tanggal Terbit</label>
            <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}" class="form-control">
          </div>

          <button type="submit" class="btn btn-primary" style="width:100%;padding:10px;margin-top:10px">Update Artikel</button>
        </div>
      </div>
    </div>
  </form>

  <script>
    function previewImg(input) {
      const img = document.getElementById('imgPreview');
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; img.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
@endsection
