<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    /**
     * Display the catalog list with search and filters.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $selectedCategory = $request->query('kategori', 'all');
        $selectedYear = $request->query('tahun', 'all');
        $sort = $request->query('sort', 'terbaru');

        $query = Book::with('category')
            ->search($search)
            ->filterCategory($selectedCategory)
            ->filterYear($selectedYear);

        switch ($sort) {
            case 'terlama':
                $query->orderBy('published_year', 'asc')->orderBy('id', 'asc');
                break;
            case 'judul_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'judul_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('published_year', 'desc')->orderBy('id', 'desc');
                break;
        }

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('books')->get();
        $years = Book::select('published_year')
            ->distinct()
            ->orderBy('published_year', 'desc')
            ->pluck('published_year');

        return view('katalog.index', compact('books', 'categories', 'years', 'search', 'selectedCategory', 'selectedYear', 'sort'));
    }

    /**
     * Display a single book detail.
     */
    public function show(Request $request, Book $book): View|JsonResponse
    {
        $book->load('category');

        if ($request->wantsJson()) {
            return $this->apiDetail($book);
        }

        $relatedBooks = Book::with('category')
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->latest()
            ->take(4)
            ->get();

        return view('katalog.show', compact('book', 'relatedBooks'));
    }

    /**
     * Reader view for interactive book reading.
     */
    public function baca(Request $request, Book $book): View
    {
        $book->load('category');

        // Increment view count
        $book->increment('views_count');

        // Log reading activity
        try {
            ReadingLog::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'user_name' => auth()->check() ? auth()->user()->name : 'Pengunjung Digital',
                'ip_address' => $request->ip(),
                'read_duration_minutes' => rand(5, 20),
                'activity_note' => 'Membaca E-Book Publikasi Online',
            ]);
        } catch (\Throwable $e) {
            // Silently continue if reading log fails
        }

        $relatedBooks = Book::with('category')
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->latest()
            ->take(3)
            ->get();

        return view('katalog.baca', compact('book', 'relatedBooks'));
    }

    /**
     * Return JSON detail for modal preview.
     */
    public function apiDetail(Book $book): JsonResponse
    {
        $book->load('category');

        return response()->json([
            'id' => $book->id,
            'name' => $book->name,
            'category' => $book->category?->name ?? 'Statistik',
            'published_year' => $book->published_year,
            'describe' => $book->describe,
            'cover_url' => $book->cover_url,
            'pdf_url' => $book->pdf_url,
            'read_url' => route('katalog.baca', $book),
            'detail_url' => route('katalog.show', $book),
        ]);
    }
}
