<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\ReadingLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReadingLogController extends Controller
{
    /**
     * Display a listing of reading activity logs.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $selectedBook = $request->query('book_id');
        $selectedUser = $request->query('user_id');
        $selectedPeriod = $request->query('period'); // 'today', 'week', 'month', 'all'
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = ReadingLog::with(['book.category', 'user']);

        if (! empty($search)) {
            $term = trim($search);
            $query->where(function ($q) use ($term) {
                $q->where('user_name', 'like', "%{$term}%")
                    ->orWhere('activity_note', 'like', "%{$term}%")
                    ->orWhere('ip_address', 'like', "%{$term}%")
                    ->orWhereHas('book', function ($bq) use ($term) {
                        $bq->where('name', 'like', "%{$term}%");
                    })
                    ->orWhereHas('user', function ($uq) use ($term) {
                        $uq->where('name', 'like', "%{$term}%")
                            ->orWhere('email', 'like', "%{$term}%");
                    });
            });
        }

        if (! empty($selectedBook) && $selectedBook !== 'all') {
            $query->where('book_id', $selectedBook);
        }

        if (! empty($selectedUser) && $selectedUser !== 'all') {
            $query->where('user_id', $selectedUser);
        }

        if ($selectedPeriod === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($selectedPeriod === 'week') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($selectedPeriod === 'month') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }

        if (! empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if (! empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $logs = $query->latest()->paginate(15)->withQueryString();

        $books = Book::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        $totalLogsCount = ReadingLog::count();
        $todayLogsCount = ReadingLog::whereDate('created_at', Carbon::today())->count();
        $uniqueReadersCount = ReadingLog::distinct('user_id')->count('user_id');

        return view('admin.reading_logs.index', compact(
            'logs',
            'books',
            'users',
            'search',
            'selectedBook',
            'selectedUser',
            'selectedPeriod',
            'startDate',
            'endDate',
            'totalLogsCount',
            'todayLogsCount',
            'uniqueReadersCount'
        ));
    }

    /**
     * Remove the specified reading log.
     */
    public function destroy(ReadingLog $readingLog): RedirectResponse
    {
        $readingLog->delete();

        return back()->with('success', 'Riwayat baca berhasil dihapus.');
    }

    /**
     * Clear all reading logs older than 60 days or clear filtered.
     */
    public function clearOld(): RedirectResponse
    {
        $deleted = ReadingLog::where('created_at', '<', Carbon::now()->subDays(60))->delete();

        return back()->with('success', "Sebanyak {$deleted} riwayat baca lama berhasil dibersihkan.");
    }
}
