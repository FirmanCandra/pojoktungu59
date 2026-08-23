<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $articles = $query->latest()->paginate(15)->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Upload PDF terlebih dahulu supaya bisa dipakai sebagai fallback judul
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $data['pdf_file'] = $pdfFile->store('articles/pdf', 'public');

            // Auto-isi judul dari nama file PDF jika judul tidak diisi
            if (empty($data['title'])) {
                $data['title'] = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            }
        }

        // Wajib ada judul (minimal dari PDF)
        if (empty($data['title'])) {
            $data['title'] = 'Artikel ' . now()->format('d/m/Y H:i');
        }

        // Konten boleh kosong
        if (empty($data['content'])) {
            $data['content'] = '';
        }

        $data['slug'] = Article::generateUniqueSlug($data['title']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Article::create($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $data = $request->validated();

        // Upload PDF dulu agar bisa jadi fallback judul
        if ($request->hasFile('pdf_file')) {
            if ($article->pdf_file) {
                Storage::disk('public')->delete($article->pdf_file);
            }
            $pdfFile = $request->file('pdf_file');
            $data['pdf_file'] = $pdfFile->store('articles/pdf', 'public');

            // Auto-isi judul dari nama file PDF jika judul dikosongkan
            if (empty($data['title'])) {
                $data['title'] = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            }
        }

        // Hapus PDF jika user centang remove_pdf
        if ($request->boolean('remove_pdf') && $article->pdf_file) {
            Storage::disk('public')->delete($article->pdf_file);
            $data['pdf_file'] = null;
        }

        // Jika judul tetap kosong, pakai judul lama
        if (empty($data['title'])) {
            $data['title'] = $article->title;
        }

        // Konten boleh kosong
        if (!isset($data['content'])) {
            $data['content'] = $article->content;
        }

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        if ($data['status'] === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        }

        $article->update($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        if ($article->pdf_file) {
            Storage::disk('public')->delete($article->pdf_file);
        }
        $article->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
