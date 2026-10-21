@extends('admin.layouts.app')

@section('title', 'Laporan & Statistik')
@section('header_title', 'Laporan Statistik Perpustakaan')
@section('header_subtitle', 'Analisis komprehensif pertumbuhan koleksi, tren pembaca, dan ekspor dokumen laporan.')

@section('content')
<div class="space-y-6">

  <!-- Header Banner & Export Actions -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <div>
      <div class="flex items-center gap-2">
        <h2 class="text-lg font-black text-[#082b62]">Laporan Kinerja Digital</h2>
        <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-700">
          Periode: {{ $periodLabel }}
        </span>
      </div>
      <p class="text-xs text-slate-500 mt-0.5">
        Data akumulasi statistik layanan diseminasi informasi perpustakaan BPS Jember.
      </p>
    </div>

    <!-- Export Buttons -->
    <div class="flex flex-wrap items-center gap-2.5">
      <a 
        href="{{ route('admin.reports.export_csv', request()->all()) }}" 
        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-emerald-700 transition"
      >
        <i data-lucide="file-spreadsheet" class="h-4 w-4"></i>
        <span>Ekspor CSV / Excel</span>
      </a>

      <a 
        href="{{ route('admin.reports.print', request()->all()) }}" 
        target="_blank"
        class="inline-flex items-center gap-2 rounded-xl bg-[#082b62] px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-blue-900 transition"
      >
        <i data-lucide="printer" class="h-4 w-4 text-yellow-400"></i>
        <span>Cetak Laporan Resmi</span>
      </a>
    </div>
  </div>

  <!-- Period Filter Tabs & Date Range -->
  <div class="rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
      
      <!-- Quick Period Pills -->
      <div class="flex flex-wrap items-center gap-2">
        @php
          $periods = [
            'hari_ini' => 'Hari Ini',
            '7_hari' => '7 Hari Terakhir',
            '30_hari' => '30 Hari Terakhir',
            'tahun_ini' => 'Tahun Ini',
            'semua' => 'Semua Waktu',
          ];
        @endphp

        @foreach($periods as $key => $label)
          <a 
            href="{{ route('admin.reports.index', ['period' => $key]) }}" 
            class="rounded-xl px-3.5 py-2 text-xs font-bold transition {{ $period === $key ? 'bg-[#082b62] text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200' }}"
          >
            {{ $label }}
          </a>
        @endforeach
      </div>

      <!-- Custom Date Picker -->
      <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
        <span class="text-xs font-bold text-slate-500">Rentang:</span>
        <input 
          type="date" 
          name="start_date" 
          value="{{ request('start_date') }}"
          class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-800 focus:outline-none"
        >
        <span class="text-xs text-slate-400">-</span>
        <input 
          type="date" 
          name="end_date" 
          value="{{ request('end_date') }}"
          class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-800 focus:outline-none"
        >
        <button 
          type="submit" 
          class="rounded-xl bg-[#082b62] px-3.5 py-2 text-xs font-bold text-white hover:bg-blue-900 transition"
        >
          Terapkan
        </button>
      </div>

    </form>
  </div>

  <!-- Key Statistics Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    
    <!-- Statistik Jumlah Buku -->
    <div class="rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
      <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Koleksi Buku</span>
      <h3 class="text-2xl font-black text-[#082b62] mt-1">{{ number_format($totalBooks) }} Judul</h3>
      <div class="mt-2 text-xs text-slate-500 flex items-center justify-between">
        <span>{{ $publishedBooks }} Terbit</span>
        <span class="font-bold text-blue-700">{{ $draftBooks }} Draft</span>
      </div>
    </div>

    <!-- Statistik Pengguna -->
    <div class="rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
      <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pengguna</span>
      <h3 class="text-2xl font-black text-[#082b62] mt-1">{{ number_format($totalUsers) }} Akun</h3>
      <div class="mt-2 text-xs text-slate-500 flex items-center justify-between">
        <span>{{ $activeUsers }} Aktif</span>
        <span class="font-bold text-emerald-600">{{ round(($activeUsers / max(1, $totalUsers)) * 100) }}% Rasio</span>
      </div>
    </div>

    <!-- Statistik Aktivitas Membaca (Periode) -->
    <div class="rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
      <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Aktivitas Periode Ini</span>
      <h3 class="text-2xl font-black text-blue-700 mt-1">{{ number_format($periodReadsCount) }} Sesi</h3>
      <p class="mt-2 text-xs text-slate-500">
        Pada rentang: <strong>{{ $periodLabel }}</strong>
      </p>
    </div>

    <!-- Statistik Total Aktivitas Sepanjang Waktu -->
    <div class="rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
      <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Sepanjang Waktu</span>
      <h3 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($totalReadsAllTime) }} Baca</h3>
      <p class="mt-2 text-xs text-slate-500">
        {{ $totalCategories }} Rumpun Kategori Statistik
      </p>
    </div>

  </div>

  <!-- Chart: Grafik Aktivitas Membaca Berdasarkan Periode -->
  <div class="rounded-2xl bg-white p-6 border border-slate-200/90 shadow-xs">
    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
      <div>
        <h3 class="text-sm font-extrabold text-[#082b62]">Grafik Tren Aktivitas Membaca Berdasarkan Periode</h3>
        <p class="text-xs text-slate-400">Distribusi jumlah sesi membaca dokumen publikasi statistik.</p>
      </div>
      <span class="rounded-xl bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
        {{ $periodLabel }}
      </span>
    </div>

    <div class="h-80">
      <canvas id="reportTimelineChart"></canvas>
    </div>
  </div>

  <!-- Bottom Breakdown: Buku Paling Banyak Dibaca & Kategori Paling Populer -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Buku Paling Banyak Dibaca -->
    <div class="lg:col-span-7 rounded-2xl bg-white p-6 border border-slate-200/90 shadow-xs">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
        <div>
          <h3 class="text-sm font-extrabold text-[#082b62]">Buku Paling Banyak Dibaca Pada Periode Ini</h3>
          <p class="text-xs text-slate-400">Peringkat publikasi dengan interaksi tertinggi.</p>
        </div>
      </div>

      <div class="space-y-3">
        @forelse($topBooks as $index => $b)
          <div class="flex items-center justify-between gap-3 p-3 rounded-xl border border-slate-100 hover:border-blue-200 transition">
            <div class="flex items-center gap-3 min-w-0">
              <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg {{ $index === 0 ? 'bg-amber-400 text-slate-900 font-black' : 'bg-slate-100 text-slate-600 font-bold' }} text-xs">
                {{ $index + 1 }}
              </span>
              <img 
                src="{{ $b->cover_url }}" 
                alt="{{ $b->name }}" 
                class="h-10 w-7 rounded-md object-cover border border-slate-200 shrink-0"
                onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
              >
              <div class="min-w-0">
                <a href="{{ route('admin.books.show', $b) }}" class="text-xs font-bold text-slate-900 hover:text-blue-700 transition block truncate">
                  {{ $b->name }}
                </a>
                <span class="text-[10px] text-blue-700 font-semibold">{{ $b->category?->name }}</span>
              </div>
            </div>

            <div class="text-right shrink-0">
              <span class="text-xs font-black text-blue-800 block">{{ $b->reading_logs_count }} sesi</span>
              <span class="text-[10px] text-slate-400">periode ini</span>
            </div>
          </div>
        @empty
          <div class="py-8 text-center text-xs text-slate-400">
            Belum ada aktivitas membaca pada periode yang dipilih.
          </div>
        @endforelse
      </div>
    </div>

    <!-- Kategori Paling Populer -->
    <div class="lg:col-span-5 rounded-2xl bg-white p-6 border border-slate-200/90 shadow-xs">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
        <div>
          <h3 class="text-sm font-extrabold text-[#082b62]">Kategori Paling Populer</h3>
          <p class="text-xs text-slate-400">Rumpun statistik dengan koleksi publikasi terbanyak.</p>
        </div>
      </div>

      <div class="space-y-4">
        @foreach($topCategories as $cat)
          @php
            $percentage = $totalBooks > 0 ? round(($cat->books_count / $totalBooks) * 100) : 0;
          @endphp
          <div>
            <div class="flex items-center justify-between text-xs mb-1">
              <span class="font-bold text-slate-800">{{ $cat->name }}</span>
              <span class="font-semibold text-slate-500">{{ $cat->books_count }} Buku ({{ $percentage }}%)</span>
            </div>
            <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
              <div class="h-full rounded-full bg-blue-600" style="width: {{ $percentage }}%"></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

  </div>

</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('reportTimelineChart');
    if (ctx) {
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: @json($chartData['labels']),
          datasets: [{
            label: 'Jumlah Sesi Membaca',
            data: @json($chartData['values']),
            backgroundColor: '#082b62',
            borderRadius: 6,
            hoverBackgroundColor: '#1565c0',
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
  });
</script>
@endpush
