@extends('layouts.public')

@section('title', $article->title ?? 'Artikel')
@section('meta_description', Str::limit(strip_tags($article->content ?? ''), 150))

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
          {{ $article->published_at ? $article->published_at->translatedFormat('d F Y') : $article->created_at->translatedFormat('d F Y') }} <i>•</i> 
          Kategori: {{ $article->category }}
        </div>

        @if($article->thumbnail)
          <div style="margin-bottom:24px">
            <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" style="width:100%;max-height:400px;object-fit:cover;border-radius:6px">
          </div>
        @endif

        @if($article->pdf_file)
          {{-- ===== PDF.js RENDERER — cross-device compatible ===== --}}
          <div style="margin:24px 0" id="pdf-wrapper">

            {{-- Loading --}}
            <div id="pdf-loading" style="text-align:center;padding:30px 0;color:#64748b;font-size:12px">
              <div style="display:inline-block;width:28px;height:28px;border:3px solid #e2e8f0;border-top-color:#4a6cf7;border-radius:50%;animation:spin .7s linear infinite;margin-bottom:10px"></div>
              <br>Memuat dokumen...
            </div>

            {{-- Semua halaman PDF --}}
            <div id="pdf-pages" style="display:flex;flex-direction:column;gap:0"></div>

            {{-- Fallback iframe (tampil jika PDF.js gagal) --}}
            <div id="pdf-fallback" style="display:none">
              <iframe
                src="{{ asset('storage/' . $article->pdf_file) }}"
                width="100%" height="800"
                style="border:1px solid #e2e8f0;border-radius:8px;display:block"
                title="Dokumen PDF">
              </iframe>
            </div>

            {{-- Error total --}}
            <div id="pdf-error" style="display:none;text-align:center;padding:24px;background:#fff5f5;border:1px solid #fecaca;border-radius:8px;color:#dc2626;font-size:12px">
              Dokumen tidak dapat ditampilkan di perangkat ini.
              <a href="{{ asset('storage/' . $article->pdf_file) }}" target="_blank"
                 style="color:#4a6cf7;margin-left:6px;font-weight:600">⬇ Unduh PDF</a>
            </div>
          </div>

          <style>
            @keyframes spin { to { transform: rotate(360deg); } }
            #pdf-pages canvas {
              width: 100% !important;
              height: auto !important;
              display: block;
              background: #fff;
            }
          </style>

          {{-- Gunakan versi stabil pdf.js --}}
          <script>
            // Muat pdf.js dari CDN, dengan fallback manual
            (function () {
              const script = document.createElement('script');
              script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js';
              script.onload = initPdfJs;
              script.onerror = showFallback;
              document.head.appendChild(script);
            })();

            function showFallback() {
              document.getElementById('pdf-loading').style.display  = 'none';
              document.getElementById('pdf-fallback').style.display = 'block';
            }

            async function initPdfJs() {
              const pdfUrl = "{{ asset('storage/' . $article->pdf_file) }}";

              // Gunakan fake worker (tidak butuh worker CDN terpisah) — lebih kompatibel
              pdfjsLib.GlobalWorkerOptions.workerSrc =
                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

              // Scale adaptif: lebih kecil di mobile agar tidak crash memori
              const isMobile = window.innerWidth < 768;
              const SCALE    = isMobile ? 1.2 : 1.6;

              try {
                const loadTask = pdfjsLib.getDocument({
                  url: pdfUrl,
                  cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/cmaps/',
                  cMapPacked: true,
                });

                const doc       = await loadTask.promise;
                const container = document.getElementById('pdf-pages');
                document.getElementById('pdf-loading').style.display = 'none';

                for (let i = 1; i <= doc.numPages; i++) {
                  try {
                    const page   = await doc.getPage(i);
                    const vp     = page.getViewport({ scale: SCALE });
                    const canvas = document.createElement('canvas');
                    const ctx    = canvas.getContext('2d');

                    // Batasi ukuran canvas agar tidak crash di HP low-end
                    const maxW   = Math.min(vp.width, 1800);
                    const ratio  = maxW / vp.width;
                    canvas.width  = vp.width  * ratio;
                    canvas.height = vp.height * ratio;

                    const scaledVp = page.getViewport({ scale: SCALE * ratio });
                    await page.render({ canvasContext: ctx, viewport: scaledVp }).promise;
                    container.appendChild(canvas);
                  } catch (pageErr) {
                    console.warn('Gagal render halaman ' + i, pageErr);
                    // Lanjut ke halaman berikutnya meski satu halaman gagal
                  }
                }

                // Jika tidak ada canvas yang berhasil di-render, tampilkan fallback
                if (container.children.length === 0) {
                  showFallback();
                }

              } catch (err) {
                console.error('PDF.js error:', err);
                showFallback();
              }
            }
          </script>
        @endif


        @if($article->content)
          <div class="article-body-content" style="font-size:13px;line-height:1.8;color:#334155">
            {!! nl2br(e($article->content)) !!}
          </div>
        @endif

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
