<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin main dashboard.
     */
    public function index(): View
    {
        // 1. Metric Cards
        $totalBooks = Book::count();
        $publishedBooks = Book::where('status', 'published')->count();
        $draftBooks = Book::where('status', 'draft')->count();

        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $adminCount = User::where('role', 'admin')->count();

        $totalCategories = Category::count();

        $totalReads = ReadingLog::count();
        $todayReads = ReadingLog::whereDate('created_at', Carbon::today())->count();

        // 2. Daily Reading Chart (Last 7 Days)
        $chartDates = [];
        $chartReadCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateLabel = $date->translatedFormat('d M');
            $count = ReadingLog::whereDate('created_at', $date)->count();

            $chartDates[] = $dateLabel;
            $chartReadCounts[] = $count;
        }

        // 3. Category Distribution for Pie / Doughnut Chart
        $categoryStats = Category::withCount('books')
            ->orderByDesc('books_count')
            ->take(6)
            ->get();

        $categoryChartLabels = $categoryStats->pluck('name')->toArray();
        $categoryChartCounts = $categoryStats->pluck('books_count')->toArray();

        // 4. Most Popular Books (by views + reading logs count)
        $popularBooks = Book::with('category')
            ->withCount(['readingLogs', 'favorites'])
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        // 5. Recent User Activity
        $recentActivities = ReadingLog::with(['user', 'book'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalBooks',
            'publishedBooks',
            'draftBooks',
            'totalUsers',
            'activeUsers',
            'adminCount',
            'totalCategories',
            'totalReads',
            'todayReads',
            'chartDates',
            'chartReadCounts',
            'categoryChartLabels',
            'categoryChartCounts',
            'popularBooks',
            'recentActivities'
        ));
    }
}
