<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of books with search and filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $selectedCategory = $request->query('category_id');
        $selectedStatus = $request->query('status');
        $selectedYear = $request->query('year');

        $query = Book::with('category')->withCount(['readingLogs', 'favorites']);

        if (! empty($search)) {
            $query->search($search);
        }

        if (! empty($selectedCategory) && $selectedCategory !== 'all') {
            $query->where('category_id', $selectedCategory);
        }

        if (! empty($selectedStatus) && $selectedStatus !== 'all') {
            $query->where('status', $selectedStatus);
        }

        if (! empty($selectedYear) && $selectedYear !== 'all') {
            $query->where('published_year', $selectedYear);
        }

        $books = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $years = Book::select('published_year')->distinct()->orderByDesc('published_year')->pluck('published_year');

        $totalBooks = Book::count();
        $publishedCount = Book::where('status', 'published')->count();
        $draftCount = Book::where('status', 'draft')->count();

        return view('admin.books.index', compact(
            'books',
            'categories',
            'years',
            'search',
            'selectedCategory',
            'selectedStatus',
            'selectedYear',
            'totalBooks',
            'publishedCount',
            'draftCount'
        ));
    }

    /**
     * Show form to create a new book.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'published_year' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'isbn' => ['nullable', 'string', 'max:50'],
            'category_id' => ['required', 'exists:categories,id'],
            'describe' => ['required', 'string'],
            'status' => ['required', 'in:published,draft'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'file_book' => ['nullable', 'file', 'mimes:pdf', 'max:51200'], // max 50MB
        ], [
            'name.required' => 'Judul buku wajib diisi.',
            'category_id.required' => 'Pilih kategori buku.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'published_year.required' => 'Tahun terbit wajib diisi.',
            'describe.required' => 'Deskripsi / sinopsis buku wajib diisi.',
            'cover.image' => 'File sampul harus berupa gambar (JPG, PNG, WEBP).',
            'file_book.mimes' => 'File buku harus berupa format PDF.',
        ]);

        $coverPath = 'assets/images/cover-buku1.jpg';
        if ($request->hasFile('cover')) {
            $coverDir = public_path('uploads/covers');
            if (! File::isDirectory($coverDir)) {
                File::makeDirectory($coverDir, 0755, true);
            }
            $coverFileName = time().'_'.uniqid().'.'.$request->file('cover')->getClientOriginalExtension();
            $request->file('cover')->move($coverDir, $coverFileName);
            $coverPath = 'uploads/covers/'.$coverFileName;
        }

        $pdfPath = 'assets/file/pdf/file1.pdf';
        if ($request->hasFile('file_book')) {
            $pdfDir = public_path('uploads/books');
            if (! File::isDirectory($pdfDir)) {
                File::makeDirectory($pdfDir, 0755, true);
            }
            $pdfFileName = time().'_'.uniqid().'.'.$request->file('file_book')->getClientOriginalExtension();
            $request->file('file_book')->move($pdfDir, $pdfFileName);
            $pdfPath = 'uploads/books/'.$pdfFileName;
        }

        $book = Book::create([
            'name' => $validated['name'],
            'author' => $validated['author'] ?: 'BPS Kabupaten Jember',
            'publisher' => $validated['publisher'] ?: 'Badan Pusat Statistik Kabupaten Jember',
            'published_year' => $validated['published_year'],
            'isbn' => $validated['isbn'],
            'category_id' => $validated['category_id'],
            'describe' => $validated['describe'],
            'status' => $validated['status'],
            'file_cover' => $coverPath,
            'file_books' => $pdfPath,
            'views_count' => 0,
        ]);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku "'.$book->name.'" berhasil ditambahkan.');
    }

    /**
     * Show detailed view of a book.
     */
    public function show(Book $book): View|JsonResponse
    {
        $book->load('category')->loadCount(['readingLogs', 'favorites']);

        if (request()->wantsJson()) {
            return response()->json([
                'id' => $book->id,
                'name' => $book->name,
                'author' => $book->author,
                'publisher' => $book->publisher,
                'published_year' => $book->published_year,
                'isbn' => $book->isbn ?: '-',
                'category' => $book->category?->name ?? 'Statistik',
                'describe' => $book->describe,
                'status' => $book->status,
                'views_count' => $book->views_count,
                'cover_url' => $book->cover_url,
                'pdf_url' => $book->pdf_url,
                'read_url' => route('katalog.baca', $book),
                'created_at' => $book->created_at->format('d M Y H:i'),
            ]);
        }

        $recentReads = $book->readingLogs()->with('user')->latest()->take(5)->get();

        return view('admin.books.show', compact('book', 'recentReads'));
    }

    /**
     * Show form to edit an existing book.
     */
    public function edit(Book $book): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'published_year' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'isbn' => ['nullable', 'string', 'max:50'],
            'category_id' => ['required', 'exists:categories,id'],
            'describe' => ['required', 'string'],
            'status' => ['required', 'in:published,draft'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'file_book' => ['nullable', 'file', 'mimes:pdf', 'max:51200'],
        ], [
            'name.required' => 'Judul buku wajib diisi.',
            'category_id.required' => 'Pilih kategori buku.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'published_year.required' => 'Tahun terbit wajib diisi.',
            'describe.required' => 'Deskripsi / sinopsis buku wajib diisi.',
        ]);

        $book->name = $validated['name'];
        $book->author = $validated['author'] ?: 'BPS Kabupaten Jember';
        $book->publisher = $validated['publisher'] ?: 'Badan Pusat Statistik Kabupaten Jember';
        $book->published_year = $validated['published_year'];
        $book->isbn = $validated['isbn'];
        $book->category_id = $validated['category_id'];
        $book->describe = $validated['describe'];
        $book->status = $validated['status'];

        if ($request->hasFile('cover')) {
            $coverDir = public_path('uploads/covers');
            if (! File::isDirectory($coverDir)) {
                File::makeDirectory($coverDir, 0755, true);
            }
            $coverFileName = time().'_'.uniqid().'.'.$request->file('cover')->getClientOriginalExtension();
            $request->file('cover')->move($coverDir, $coverFileName);
            $book->file_cover = 'uploads/covers/'.$coverFileName;
        }

        if ($request->hasFile('file_book')) {
            $pdfDir = public_path('uploads/books');
            if (! File::isDirectory($pdfDir)) {
                File::makeDirectory($pdfDir, 0755, true);
            }
            $pdfFileName = time().'_'.uniqid().'.'.$request->file('file_book')->getClientOriginalExtension();
            $request->file('file_book')->move($pdfDir, $pdfFileName);
            $book->file_books = 'uploads/books/'.$pdfFileName;
        }

        $book->save();

        return redirect()->route('admin.books.index')
            ->with('success', 'Data buku "'.$book->name.'" berhasil diperbarui.');
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $bookTitle = $book->name;
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku "'.$bookTitle.'" berhasil dihapus.');
    }
}
