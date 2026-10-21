@extends('admin.layouts.app')

@section('title', 'Dashboard Ringkasan')
@section('header_title', 'Ringkasan Perpustakaan Digital')
@section('header_subtitle', 'Statistik umum koleksi publikasi statistik, pembaca, dan aktivitas sistem.')

@section('content')
<div class="space-y-6">

  <!-- 1. Top Metrics Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
    
    <!-- Card Total Buku -->
    <div class="relative overflow-hidden rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Buku Publikasi</span>
          <h3 class="text-2xl sm:text-3xl font-black text-[#082b62] mt-1">{{ number_format($totalBooks) }}</h3>
          <div class="mt-2 flex items-center gap-2 text-[11px]">
            <span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
              <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
              {{ $publishedBooks }} Terbit
            </span>
            <span class="text-slate-400">&bull;</span>
            <span class="text-slate-500 font-medium">{{ $draftBooks }} Draft</span>
          </div>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-[#1565c0]">
          <i data-lucide="book-open" class="h-6 w-6"></i>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
    </div>

    <!-- Card Total Pengguna -->
    <div class="relative overflow-hidden rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pengguna</span>
          <h3 class="text-2xl sm:text-3xl font-black text-[#082b62] mt-1">{{ number_format($totalUsers) }}</h3>
          <div class="mt-2 flex items-center gap-2 text-[11px]">
            <span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
              <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
              {{ $activeUsers }} Aktif
            </span>
            <span class="text-slate-400">&bull;</span>
            <span class="text-slate-500 font-medium">{{ $adminCount }} Admin</span>
          </div>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-50 text-sky-700">
          <i data-lucide="users" class="h-6 w-6"></i>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-500 to-blue-500"></div>
    </div>

    <!-- Card Total Kategori -->
    <div class="relative overflow-hidden rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Kategori</span>
          <h3 class="text-2xl sm:text-3xl font-black text-[#082b62] mt-1">{{ number_format($totalCategories) }}</h3>
          <div class="mt-2 flex items-center gap-2 text-[11px]">
            <span class="inline-flex items-center gap-1 font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">
              Rumpun Data BPS
            </span>
          </div>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
          <i data-lucide="tags" class="h-6 w-6"></i>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-yellow-500"></div>
    </div>

    <!-- Card Total Aktivitas Baca -->
    <div class="relative overflow-hidden rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aktivitas Membaca</span>
          <h3 class="text-2xl sm:text-3xl font-black text-[#082b62] mt-1">{{ number_format($totalReads) }}</h3>
          <div class="mt-2 flex items-center gap-2 text-[11px]">
            <span class="inline-flex items-center gap-1 font-bold text-yellow-800 bg-yellow-100 px-2 py-0.5 rounded-md">
              <i data-lucide="sparkles" class="h-3 w-3 text-yellow-600"></i>
              {{ $todayReads }} Hari Ini
            </span>
          </div>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
          <i data-lucide="activity" class="h-6 w-6"></i>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
    </div>

  </div>

  <!-- Quick Action Strip -->
  <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-white p-4 border border-slate-200/90 shadow-xs">
    <div class="flex items-center gap-2">
      <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-50 text-[#082b62]">
        <i data-lucide="command" class="h-4 w-4"></i>
      </span>
      <span class="text-xs font-bold text-slate-800">Aksi Cepat Admin:</span>
    </div>

    <div class="flex flex-wrap items-center gap-2">
      <a 
        href="{{ route('admin.books.create') }}" 
        class="inline-flex items-center gap-1.5 rounded-xl bg-[#082b62] px-3.5 py-2 text-xs font-bold text-white shadow-xs hover:bg-blue-900 transition"
      >
        <i data-lucide="plus-circle" class="h-3.5 w-3.5 text-yellow-400"></i>
        <span>Tambah Buku Baru</span>
      </a>

      <a 
        href="{{ route('admin.users.create') }}" 
        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 transition"
      >
        <i data-lucide="user-plus" class="h-3.5 w-3.5 text-blue-600"></i>
        <span>Tambah Pengguna</span>
      </a>

      <a 
        href="{{ route('admin.categories.index') }}" 
        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 transition"
      >
        <i data-lucide="folder-plus" class="h-3.5 w-3.5 text-amber-600"></i>
        <span>Kelola Kategori</span>
      </a>

      <a 
        href="{{ route('admin.reports.export_csv') }}" 
        class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3.5 py-2 text-xs font-bold text-emerald-800 hover:bg-emerald-100 transition"
      >
        <i data-lucide="download" class="h-3.5 w-3.5 text-emerald-600"></i>
        <span>Unduh Laporan CSV</span>
      </a>
    </div>
  </div>

  <!-- 2. Charts Section -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Main Chart: Daily Reading Activity -->
    <div class="lg:col-span-8 rounded-2xl bg-white p-5 sm:p-6 border border-slate-200/90 shadow-xs">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
        <div>
          <h4 class="text-sm font-extrabold text-[#082b62]">Grafik Tren Aktivitas Membaca</h4>
          <p class="text-xs text-slate-400">Frekuensi pembacaan dokumen publikasi statistik selama 7 hari terakhir.</p>
        </div>
        <div class="inline-flex items-center gap-1 rounded-xl bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
          <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
          <span>7 Hari Terakhir</span>
        </div>
      </div>
      <div class="mt-4 h-72">
        <canvas id="readingChart"></canvas>
      </div>
    </div>

    <!-- Secondary Chart: Category Distribution -->
    <div class="lg:col-span-4 rounded-2xl bg-white p-5 sm:p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
      <div class="pb-4 border-b border-slate-100">
        <h4 class="text-sm font-extrabold text-[#082b62]">Distribusi Kategori</h4>
        <p class="text-xs text-slate-400">Proporsi buku per bidang statistik.</p>
      </div>
      <div class="py-2 h-56 flex items-center justify-center">
        <canvas id="categoryChart"></canvas>
      </div>
      <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
        <span>Total {{ $totalCategories }} Rumpun Kategori</span>
        <a href="{{ route('admin.categories.index') }}" class="font-bold text-blue-700 hover:underline">Lihat Semua &rarr;</a>
      </div>
    </div>

  </div>

  <!-- 3. Bottom Grid: Popular Books & Recent User Activities -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Popular Books (Daftar Buku Paling Populer) -->
    <div class="lg:col-span-7 rounded-2xl bg-white p-5 sm:p-6 border border-slate-200/90 shadow-xs">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
        <div>
          <h4 class="text-sm font-extrabold text-[#082b62]">Buku & Publikasi Paling Populer</h4>
          <p class="text-xs text-slate-400">Buku dengan tingkat kunjungan dan pembacaan tertinggi.</p>
        </div>
        <a href="{{ route('admin.books.index') }}" class="text-xs font-bold text-[#1565c0] hover:underline">
          Kelola Semua Buku &rarr;
        </a>
      </div>

      <div class="space-y-3">
        @forelse($popularBooks as $index => $book)
          <div class="flex items-center justify-between gap-3 p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/30 transition">
            <div class="flex items-center gap-3 min-w-0">
              <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg {{ $index === 0 ? 'bg-yellow-400 text-slate-900 font-extrabold' : 'bg-slate-100 text-slate-600 font-bold' }} text-xs">
                {{ $index + 1 }}
              </span>
              <img 
                src="{{ $book->cover_url }}" 
                alt="{{ $book->name }}" 
                class="h-12 w-9 rounded-md object-cover shadow-xs shrink-0 border border-slate-200"
                onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
              >
              <div class="min-w-0">
                <a href="{{ route('admin.books.show', $book) }}" class="text-xs font-bold text-slate-900 hover:text-blue-700 transition truncate block">
                  {{ $book->name }}
                </a>
                <div class="flex items-center gap-2 mt-0.5 text-[11px] text-slate-500">
                  <span class="text-blue-700 font-semibold">{{ $book->category?->name ?? 'Statistik' }}</span>
                  <span>&bull;</span>
                  <span>Tahun {{ $book->published_year }}</span>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
              <div class="text-right">
                <span class="text-xs font-extrabold text-slate-800 block">{{ number_format($book->views_count) }}</span>
                <span class="text-[10px] text-slate-400">pembaca</span>
              </div>
              <a 
                href="{{ route('admin.books.show', $book) }}" 
                class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-blue-700 transition"
                title="Lihat Detail"
              >
                <i data-lucide="eye" class="h-4 w-4"></i>
              </a>
            </div>
          </div>
        @empty
          <div class="py-8 text-center text-xs text-slate-400">
            Belum ada data buku populer.
          </div>
        @endforelse
      </div>
    </div>

    <!-- Recent User Activities (Aktivitas Terbaru Pengguna) -->
    <div class="lg:col-span-5 rounded-2xl bg-white p-5 sm:p-6 border border-slate-200/90 shadow-xs">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
        <div>
          <h4 class="text-sm font-extrabold text-[#082b62]">Aktivitas Pengguna Terbaru</h4>
          <p class="text-xs text-slate-400">Log pembacaan publikasi terkini secara real-time.</p>
        </div>
        <a href="{{ route('admin.reading_logs.index') }}" class="text-xs font-bold text-[#1565c0] hover:underline">
          Lihat Semua Log &rarr;
        </a>
      </div>

      <div class="space-y-3.5">
        @forelse($recentActivities as $log)
          <div class="flex items-start gap-3">
            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
              <i data-lucide="book-open" class="h-4 w-4"></i>
            </span>
            <div class="min-w-0 flex-1">
              <div class="flex items-center justify-between gap-2">
                <p class="text-xs font-bold text-slate-800 truncate">
                  {{ $log->user ? $log->user->name : ($log->user_name ?: 'Pengunjung') }}
                </p>
                <span class="text-[10px] text-slate-400 shrink-0">
                  {{ $log->created_at->diffForHumans() }}
                </span>
              </div>
              <p class="text-[11px] text-slate-600 truncate mt-0.5">
                {{ $log->book ? $log->book->name : 'Publikasi' }}
              </p>
              <div class="mt-1 flex items-center gap-2 text-[10px] text-slate-400">
                <span class="inline-flex items-center gap-1 text-emerald-700 font-medium">
                  <span class="h-1 w-1 rounded-full bg-emerald-500"></span>
                  {{ $log->activity_note }}
                </span>
                <span>&bull;</span>
                <span>{{ $log->read_duration_minutes }} menit</span>
              </div>
            </div>
          </div>
        @empty
          <div class="py-8 text-center text-xs text-slate-400">
            Belum ada aktivitas membaca tercatat.
          </div>
        @endforelse
      </div>
    </div>

  </div>

</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // 1. Reading Chart (Line / Area)
    const ctxReading = document.getElementById('readingChart');
    if (ctxReading) {
      new Chart(ctxReading, {
        type: 'line',
        data: {
          labels: @json($chartDates),
          datasets: [{
            label: 'Frekuensi Membaca',
            data: @json($chartReadCounts),
            borderColor: '#1565c0',
            backgroundColor: 'rgba(21, 101, 192, 0.08)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.35,
            pointBackgroundColor: '#082b62',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: '#082b62',
              titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
              bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
              padding: 10,
              cornerRadius: 10,
            }
          },
          scales: {
            x: {
              grid: { display: false },
              ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } }
            },
            y: {
              beginAtZero: true,
              grid: { color: '#f1f5f9' },
              ticks: { precision: 0, font: { family: 'Plus Jakarta Sans', size: 11 } }
            }
          }
        }
      });
    }

    // 2. Category Doughnut Chart
    const ctxCategory = document.getElementById('categoryChart');
    if (ctxCategory) {
      new Chart(ctxCategory, {
        type: 'doughnut',
        data: {
          labels: @json($categoryChartLabels),
          datasets: [{
            data: @json($categoryChartCounts),
            backgroundColor: [
              '#082b62',
              '#1565c0',
              '#e9ad36',
              '#0284c7',
              '#10b981',
              '#6366f1'
            ],
            borderWidth: 2,
            borderColor: '#ffffff',
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                boxWidth: 12,
                font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' },
                padding: 12,
              }
            }
          },
          cutout: '68%',
        }
      });
    }
  });
</script>
@endpush
