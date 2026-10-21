@extends('admin.layouts.app')

@section('title', 'Detail Buku - ' . $book->name)
@section('header_title', 'Rincian Buku & Publikasi')
@section('header_subtitle', 'Informasi mendalam dan statistik pembaca untuk buku ini.')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
  
  <!-- Breadcrumb & Back Link -->
  <div class="flex items-center justify-between">
    <a href="{{ route('admin.books.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 hover:underline">
      <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
      <span>Kembali ke Daftar Buku</span>
    </a>

    <div class="flex items-center gap-2">
      <a 
        href="{{ route('admin.books.edit', $book) }}" 
        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs"
      >
        <i data-lucide="edit-3" class="h-3.5 w-3.5 text-amber-600"></i>
        <span>Edit Buku</span>
      </a>

      <a 
        href="{{ route('katalog.baca', $book) }}" 
        target="_blank"
        class="inline-flex items-center gap-1.5 rounded-xl bg-[#082b62] px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-blue-900 transition"
      >
        <i data-lucide="book-open" class="h-3.5 w-3.5 text-yellow-400"></i>
        <span>Buka E-Reader</span>
      </a>
    </div>
  </div>

  <!-- Book Main Overview Card -->
  <div class="rounded-3xl bg-white p-6 sm:p-8 border border-slate-200/90 shadow-xs">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
      
      <!-- Left: Book Cover -->
      <div class="md:col-span-4 lg:col-span-3 flex flex-col items-center">
        <div class="w-full aspect-[3/4] max-w-[240px] rounded-2xl overflow-hidden shadow-lg border border-slate-200 bg-slate-100">
          <img 
            src="{{ $book->cover_url }}" 
            alt="{{ $book->name }}" 
            class="h-full w-full object-cover"
            onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
          >
        </div>

        <div class="mt-4 w-full max-w-[240px] space-y-2">
          <a 
            href="{{ $book->pdf_url }}" 
            target="_blank" 
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-100 transition"
          >
            <i data-lucide="download" class="h-4 w-4 text-blue-600"></i>
            <span>Unduh Berkas PDF</span>
          </a>
        </div>
      </div>

      <!-- Right: Book Details & Stats -->
      <div class="md:col-span-8 lg:col-span-9 space-y-6">
        
        <div>
          <div class="flex flex-wrap items-center gap-2 mb-2">
            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 border border-blue-100">
              {{ $book->category?->name ?? 'Statistik' }}
            </span>

            @if($book->status === 'published')
              <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                Published
              </span>
            @else
              <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600 border border-slate-200">
                Draft
              </span>
            @endif

            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
              Tahun {{ $book->published_year }}
            </span>
          </div>

          <h2 class="text-xl sm:text-2xl font-black text-[#082b62] leading-snug">
            {{ $book->name }}
          </h2>
        </div>

        <!-- Quick Metrics -->
        <div class="grid grid-cols-3 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
          <div>
            <span class="text-[11px] text-slate-400 block font-medium">Total Dibaca</span>
            <span class="text-lg font-extrabold text-slate-900 mt-0.5 block">{{ number_format($book->views_count) }}x</span>
          </div>
          <div>
            <span class="text-[11px] text-slate-400 block font-medium">Riwayat Sesi</span>
            <span class="text-lg font-extrabold text-blue-700 mt-0.5 block">{{ $book->reading_logs_count }} sesi</span>
          </div>
          <div>
            <span class="text-[11px] text-slate-400 block font-medium">Favorit Pengguna</span>
            <span class="text-lg font-extrabold text-amber-600 mt-0.5 block">{{ $book->favorites_count }} bookmark</span>
          </div>
        </div>

        <!-- Metadata Table -->
        <div class="divide-y divide-slate-100 border-y border-slate-100 text-xs">
          <div class="py-2.5 grid grid-cols-3 gap-4">
            <span class="font-bold text-slate-400">Penulis / Tim</span>
            <span class="col-span-2 text-slate-800 font-semibold">{{ $book->author ?: 'BPS Kabupaten Jember' }}</span>
          </div>
          <div class="py-2.5 grid grid-cols-3 gap-4">
            <span class="font-bold text-slate-400">Penerbit Resmi</span>
            <span class="col-span-2 text-slate-800 font-semibold">{{ $book->publisher ?: 'Badan Pusat Statistik Kabupaten Jember' }}</span>
          </div>
          <div class="py-2.5 grid grid-cols-3 gap-4">
            <span class="font-bold text-slate-400">Nomor ISBN</span>
            <span class="col-span-2 text-slate-800 font-mono">{{ $book->isbn ?: 'Belum diisi' }}</span>
          </div>
          <div class="py-2.5 grid grid-cols-3 gap-4">
            <span class="font-bold text-slate-400">Waktu Ditambahkan</span>
            <span class="col-span-2 text-slate-800">{{ $book->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
          </div>
        </div>

        <!-- Sinopsis -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi & Sinopsis</h4>
          <p class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-blue-50/30 p-4 rounded-xl border border-blue-100/60">
            {{ $book->describe }}
          </p>
        </div>

      </div>

    </div>
  </div>

  <!-- Recent Reads on this Book -->
  <div class="rounded-2xl bg-white p-6 border border-slate-200/90 shadow-xs">
    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
      <div>
        <h3 class="text-sm font-extrabold text-[#082b62]">Aktivitas Pembaca Terkini Buku Ini</h3>
        <p class="text-xs text-slate-400">Daftar pengguna yang baru-baru ini mengakses atau membaca publikasi ini.</p>
      </div>
      <a href="{{ route('admin.reading_logs.index', ['book_id' => $book->id]) }}" class="text-xs font-bold text-[#1565c0] hover:underline">
        Lihat Semua Log Buku Ini &rarr;
      </a>
    </div>

    <div class="divide-y divide-slate-100 text-xs">
      @forelse($recentReads as $log)
        <div class="py-3 flex items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-700 font-bold text-xs">
              {{ substr($log->user ? $log->user->name : ($log->user_name ?: 'P'), 0, 1) }}
            </div>
            <div>
              <p class="font-bold text-slate-800">
                {{ $log->user ? $log->user->name : ($log->user_name ?: 'Pengunjung') }}
              </p>
              <p class="text-[11px] text-slate-400">{{ $log->activity_note }} &bull; {{ $log->read_duration_minutes }} menit</p>
            </div>
          </div>
          <span class="text-slate-400 text-[11px] whitespace-nowrap">
            {{ $log->created_at->diffForHumans() }}
          </span>
        </div>
      @empty
        <div class="py-6 text-center text-xs text-slate-400">
          Belum ada riwayat pembaca khusus untuk publikasi ini.
        </div>
      @endforelse
    </div>
  </div>

</div>
@endsection
