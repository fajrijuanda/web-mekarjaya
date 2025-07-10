<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ArticleController extends Controller
{
    /**
     * Menampilkan daftar semua artikel.
     */
    public function index()
    {
        $articles = Article::with('user:id,name') // Hanya ambil id dan nama user
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Articles/Index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        return Inertia::render('Admin/Articles/ArticleForm', [
            'article' => null // Tidak ada artikel saat membuat baru
        ]);
    }

    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|json',
            'status' => 'required|in:draft,published',
        ]);

        $request->user()->articles()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit artikel yang ada.
     */
    public function edit(Article $article)
    {
        return Inertia::render('Admin/Articles/ArticleForm', [
            'article' => $article,
        ]);
    }

    /**
     * Memperbarui artikel yang ada di database.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|json',
            'status' => 'required|in:draft,published',
        ]);

        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . $article->id,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Menghapus artikel dari database.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Menampilkan daftar artikel yang sudah di-publish untuk publik.
     */
    public function publicIndex()
    {
        $articles = Article::with('user:id,name')
            ->where('status', 'published') // <-- Hanya ambil artikel yang sudah publish
            ->latest()
            ->paginate(9);

        return Inertia::render('Public/Articles/Index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Menampilkan satu artikel untuk publik berdasarkan slug.
     */
    public function publicShow(Article $article)
    {
        // Pastikan hanya artikel yang sudah publish yang bisa diakses
        if ($article->status !== 'published') {
            abort(404);
        }

        // Load relasi user untuk ditampilkan
        $article->load('user:id,name');

        return Inertia::render('Public/Articles/Show', [
            'article' => $article,
        ]);
    }

}