<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Display the landing homepage with dynamic books and categories.
     */
    public function index(): View
    {
        $featuredBooks = Book::with('category')
            ->latest()
            ->take(10)
            ->get();

        $categories = Category::withCount('books')->get();
        $totalBooks = Book::count();
        $totalCategories = Category::count();

        return view('welcome', compact('featuredBooks', 'categories', 'totalBooks', 'totalCategories'));
    }
}
