<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\ReadingLog;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display comprehensive library reports and statistics.
     */
    public function index(Request $request): View
    {
        $period = $request->query('period', '30_hari'); // 'hari_ini', '7_hari', '30_hari', 'tahun_ini', 'semua'
        $customStart = $request->query('start_date');
        $customEnd = $request->query('end_date');

        [$startDate, $endDate, $periodLabel] = $this->resolveDateRange($period, $customStart, $customEnd);

        // Core Metrics
        $totalBooks = Book::count();
        $publishedBooks = Book::where('status', 'published')->count();
        $draftBooks = Book::where('status', 'draft')->count();

        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();

        $totalCategories = Category::count();

        $totalReadsAllTime = ReadingLog::count();
        $periodReadsQuery = ReadingLog::query();
        if ($startDate && $endDate) {
            $periodReadsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $periodReadsCount = $periodReadsQuery->count();

        // Top Read Books in Period
        $topBooks = Book::with('category')
            ->withCount(['readingLogs' => function ($q) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                }
            }])
            ->orderByDesc('reading_logs_count')
            ->take(8)
            ->get();

        // Popular Categories
        $topCategories = Category::withCount('books')
            ->orderByDesc('books_count')
            ->get();

        // Period Timeline Chart Data
        $chartData = $this->buildTimelineChartData($period, $startDate, $endDate);

        return view('admin.reports.index', compact(
            'period',
            'periodLabel',
            'startDate',
            'endDate',
            'totalBooks',
            'publishedBooks',
            'draftBooks',
            'totalUsers',
            'activeUsers',
            'totalCategories',
            'totalReadsAllTime',
            'periodReadsCount',
            'topBooks',
            'topCategories',
            'chartData'
        ));
    }

    /**
     * Export reports as CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $period = $request->query('period', '30_hari');
        $customStart = $request->query('start_date');
        $customEnd = $request->query('end_date');

        [$startDate, $endDate, $periodLabel] = $this->resolveDateRange($period, $customStart, $customEnd);

        $logsQuery = ReadingLog::with(['book.category', 'user'])->latest();
        if ($startDate && $endDate) {
            $logsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $logs = $logsQuery->get();

        $fileName = 'Laporan_Aktivitas_Perpus_BPS_'.date('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($logs, $periodLabel) {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // Header info
            fputcsv($handle, ['LAPORAN AKTIVITAS PERPUSTAKAAN DIGITAL BPS KABUPATEN JEMBER']);
            fputcsv($handle, ['Periode:', $periodLabel]);
            fputcsv($handle, ['Tanggal Unduh:', Carbon::now()->translatedFormat('d F Y H:i')]);
            fputcsv($handle, []); // empty line

            // Column Headers
            fputcsv($handle, ['No', 'Waktu Baca', 'Nama Pengguna', 'Email', 'Judul Buku', 'Kategori', 'Tahun Terbit', 'Aktivitas / Catatan', 'Durasi (Menit)', 'IP Address']);

            $no = 1;
            foreach ($logs as $log) {
                fputcsv($handle, [
                    $no++,
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user ? $log->user->name : ($log->user_name ?: 'Pengunjung'),
                    $log->user ? $log->user->email : '-',
                    $log->book ? $log->book->name : 'Buku dihapus',
                    $log->book && $log->book->category ? $log->book->category->name : '-',
                    $log->book ? $log->book->published_year : '-',
                    $log->activity_note,
                    $log->read_duration_minutes,
                    $log->ip_address,
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    /**
     * Printable report view.
     */
    public function printView(Request $request): View
    {
        $period = $request->query('period', '30_hari');
        $customStart = $request->query('start_date');
        $customEnd = $request->query('end_date');

        [$startDate, $endDate, $periodLabel] = $this->resolveDateRange($period, $customStart, $customEnd);

        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalReads = ReadingLog::count();

        $topBooks = Book::with('category')
            ->withCount(['readingLogs' => function ($q) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                }
            }])
            ->orderByDesc('reading_logs_count')
            ->take(15)
            ->get();

        $categories = Category::withCount('books')->orderByDesc('books_count')->get();

        $recentLogs = ReadingLog::with(['book.category', 'user'])
            ->latest()
            ->take(25)
            ->get();

        $libraryName = Setting::get('library_name', 'Perpustakaan Digital BPS Kabupaten Jember');
        $libraryAddress = Setting::get('contact_address', 'Jl. Kartini No. 19, Kepatihan, Jember');

        return view('admin.reports.print', compact(
            'periodLabel',
            'totalBooks',
            'totalUsers',
            'totalReads',
            'topBooks',
            'categories',
            'recentLogs',
            'libraryName',
            'libraryAddress'
        ));
    }

    /**
     * Resolve date range based on period option.
     */
    private function resolveDateRange(string $period, ?string $customStart, ?string $customEnd): array
    {
        $now = Carbon::now();

        if (! empty($customStart) && ! empty($customEnd)) {
            $start = Carbon::parse($customStart)->startOfDay();
            $end = Carbon::parse($customEnd)->endOfDay();

            return [$start, $end, $start->format('d/m/Y').' - '.$end->format('d/m/Y')];
        }

        switch ($period) {
            case 'hari_ini':
                return [$now->copy()->startOfDay(), $now->copy()->endOfDay(), 'Hari Ini ('.$now->translatedFormat('d M Y').')'];
            case '7_hari':
                return [$now->copy()->subDays(6)->startOfDay(), $now->copy()->endOfDay(), '7 Hari Terakhir'];
            case 'tahun_ini':
                return [$now->copy()->startOfYear(), $now->copy()->endOfYear(), 'Tahun Ini ('.$now->year.')'];
            case 'semua':
                return [null, null, 'Semua Waktu'];
            case '30_hari':
            default:
                return [$now->copy()->subDays(29)->startOfDay(), $now->copy()->endOfDay(), '30 Hari Terakhir'];
        }
    }

    /**
     * Build chart timeline data points for Chart.js.
     */
    private function buildTimelineChartData(string $period, ?Carbon $startDate, ?Carbon $endDate): array
    {
        $labels = [];
        $values = [];

        if ($period === 'hari_ini') {
            for ($h = 0; $h < 24; $h += 2) {
                $labels[] = str_pad($h, 2, '0', STR_PAD_LEFT).':00';
                $values[] = ReadingLog::whereDate('created_at', Carbon::today())
                    ->whereTime('created_at', '>=', str_pad($h, 2, '0', STR_PAD_LEFT).':00:00')
                    ->whereTime('created_at', '<', str_pad($h + 2, 2, '0', STR_PAD_LEFT).':00:00')
                    ->count();
            }
        } elseif ($period === '7_hari') {
            for ($i = 6; $i >= 0; $i--) {
                $d = Carbon::today()->subDays($i);
                $labels[] = $d->translatedFormat('D, d M');
                $values[] = ReadingLog::whereDate('created_at', $d)->count();
            }
        } elseif ($period === 'tahun_ini') {
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = Carbon::create(date('Y'), $m, 1)->translatedFormat('M');
                $values[] = ReadingLog::whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', $m)
                    ->count();
            }
        } else {
            // Default 30 days grouped in 5-day buckets or daily
            for ($i = 29; $i >= 0; $i -= 3) {
                $d = Carbon::today()->subDays($i);
                $labels[] = $d->translatedFormat('d M');
                $values[] = ReadingLog::whereBetween('created_at', [
                    $d->copy()->startOfDay(),
                    $d->copy()->addDays(2)->endOfDay(),
                ])->count();
            }
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
