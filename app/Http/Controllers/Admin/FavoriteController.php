<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * Display books ranked by most favorites + detailed user bookmark activity.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $selectedCategory = $request->query('category_id');

        // 1. Books ranked by favorites count
        $booksQuery = Book::with('category')
            ->withCount('favorites')
            ->having('favorites_count', '>', 0);

        if (! empty($search)) {
            $term = trim($search);
            $booksQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('author', 'like', "%{$term}%")
                    ->orWhere('isbn', 'like', "%{$term}%");
            });
        }

        if (! empty($selectedCategory) && $selectedCategory !== 'all') {
            $booksQuery->where('category_id', $selectedCategory);
        }

        $popularFavoriteBooks = $booksQuery->orderByDesc('favorites_count')
            ->paginate(10, ['*'], 'books_page')
            ->withQueryString();

        // 2. Recent bookmark logs with user info
        $recentFavorites = Favorite::with(['user', 'book.category'])
            ->latest()
            ->paginate(12, ['*'], 'logs_page')
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        $totalFavorites = Favorite::count();
        $totalFavoritedBooks = Book::has('favorites')->count();

        return view('admin.favorites.index', compact(
            'popularFavoriteBooks',
            'recentFavorites',
            'categories',
            'search',
            'selectedCategory',
            'totalFavorites',
            'totalFavoritedBooks'
        ));
    }

    /**
     * Remove a favorite record if needed by admin.
     */
    public function destroy(Favorite $favorite): RedirectResponse
    {
        $favorite->delete();

        return back()->with('success', 'Data bookmark favorit berhasil dihapus.');
    }
}
