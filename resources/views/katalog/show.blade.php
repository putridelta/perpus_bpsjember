@extends('guest.layouts.app')

@section('title', $book->name . ' - Perpustakaan Digital BPS Kabupaten Jember')

@section('content')
<div class="site-width py-10">
  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
    <a href="{{ route('home') }}" class="hover:text-blue-700 transition flex items-center gap-1">
      <i data-lucide="home" class="h-3.5 w-3.5"></i>
      <span>Beranda</span>
    </a>
    <i data-lucide="chevron-right" class="h-3.5 w-3.5 text-slate-400"></i>
    <a href="{{ route('katalog.index') }}" class="hover:text-blue-700 transition">Daftar Katalog</a>
    <i data-lucide="chevron-right" class="h-3.5 w-3.5 text-slate-400"></i>
    <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $book->name }}</span>
  </nav>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Cover & Quick Actions (Col 4) -->
    <div class="lg:col-span-4 flex flex-col gap-4">
      <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm overflow-hidden">
        <div class="aspect-[3/4] w-full rounded-2xl overflow-hidden shadow-inner bg-slate-100">
          <img 
            src="{{ $book->cover_url }}" 
            alt="{{ $book->name }}" 
            class="h-full w-full object-cover"
            onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
          >
        </div>
      </div>

      <div class="flex flex-col gap-2.5">
        <a 
          href="{{ route('katalog.baca', $book) }}" 
          class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#082b62] px-6 py-3.5 text-sm font-bold text-white shadow-lg hover:bg-[#124b96] transition transform hover:-translate-y-0.5"
        >
          <i data-lucide="book-open" class="h-5 w-5"></i>
          <span>Baca Buku Sekarang</span>
        </a>

        <a 
          href="{{ $book->pdf_url }}" 
          download="{{ \Illuminate\Support\Str::slug($book->name) }}.pdf"
          target="_blank" 
          class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-300 bg-white px-6 py-3 text-xs font-bold text-slate-700 hover:bg-slate-50 transition"
        >
          <i data-lucide="download" class="h-4 w-4"></i>
          <span>Unduh Berkas PDF</span>
        </a>
      </div>
    </div>

    <!-- Book Details & Metadata (Col 8) -->
    <div class="lg:col-span-8 flex flex-col rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
      <div class="border-b border-slate-100 pb-5 mb-6">
        <div class="flex flex-wrap items-center gap-2 mb-3">
          <span class="rounded-full bg-blue-100 px-3.5 py-1 text-xs font-bold text-blue-800">
            {{ $book->category?->name ?? 'Publikasi BPS' }}
          </span>
          <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
            Tahun Rilis: {{ $book->published_year }}
          </span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#082b62] leading-tight">
          {{ $book->name }}
        </h1>
      </div>

      <!-- Overview / Description -->
      <div class="space-y-4 text-sm text-slate-700 leading-relaxed">
        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
          <i data-lucide="align-left" class="h-4 w-4 text-blue-600"></i>
          <span>Deskripsi Publikasi</span>
        </h2>
        <p>{{ $book->describe }}</p>
        <p>
          Publikasi ini menyajikan data agregat dan sektoral resmi yang dirilis oleh Badan Pusat Statistik Kabupaten Jember guna menyediakan potret komprehensif indikator pembangunan di wilayah Kabupaten Jember, Jawa Timur.
        </p>
      </div>

      <!-- Metadata Table -->
      <div class="mt-8 pt-6 border-t border-slate-100">
        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
          <i data-lucide="info" class="h-4 w-4 text-blue-600"></i>
          <span>Informasi Publikasi</span>
        </h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-xs">
          <div class="flex justify-between py-2 border-b border-slate-100">
            <dt class="text-slate-500 font-medium">Instansi Penerbit</dt>
            <dd class="text-slate-800 font-semibold text-right">BPS Kabupaten Jember</dd>
          </div>
          <div class="flex justify-between py-2 border-b border-slate-100">
            <dt class="text-slate-500 font-medium">Tahun Publikasi</dt>
            <dd class="text-slate-800 font-semibold text-right">{{ $book->published_year }}</dd>
          </div>
          <div class="flex justify-between py-2 border-b border-slate-100">
            <dt class="text-slate-500 font-medium">Kategori</dt>
            <dd class="text-slate-800 font-semibold text-right">{{ $book->category?->name }}</dd>
          </div>
          <div class="flex justify-between py-2 border-b border-slate-100">
            <dt class="text-slate-500 font-medium">Format Akses</dt>
            <dd class="text-emerald-700 font-bold text-right">Online Flip/PDF Reader</dd>
          </div>
        </dl>
      </div>

      <!-- Action Footer -->
      <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-blue-700 transition">
          <i data-lucide="arrow-left" class="h-4 w-4"></i>
          <span>Kembali ke Daftar Katalog</span>
        </a>

        <a 
          href="{{ route('katalog.baca', $book) }}" 
          class="inline-flex items-center gap-2 rounded-xl bg-yellow-400 px-5 py-2.5 text-xs font-extrabold text-slate-900 shadow-sm hover:bg-yellow-300 transition"
        >
          <i data-lucide="book-open" class="h-4 w-4"></i>
          <span>Mulai Membaca Sekarang</span>
        </a>
      </div>

    </div>

  </div>

  <!-- Related Books Section -->
  @if(isset($relatedBooks) && $relatedBooks->count() > 0)
    <div class="mt-16">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="text-xl font-extrabold text-[#082b62]">Publikasi Terkait Lainnya</h2>
          <p class="text-xs text-slate-500 mt-1">Koleksi dalam kategori yang sama</p>
        </div>
        <a href="{{ route('katalog.index', ['kategori' => $book->category_id]) }}" class="text-xs font-bold text-blue-700 hover:underline">
          Lihat Semua &rarr;
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($relatedBooks as $rel)
          <article class="flex flex-col rounded-2xl border border-slate-200 bg-white p-4 shadow-xs hover:shadow-md transition">
            <div class="aspect-[3/4] w-full rounded-xl overflow-hidden bg-slate-100 mb-3">
              <img 
                src="{{ $rel->cover_url }}" 
                alt="{{ $rel->name }}" 
                class="h-full w-full object-cover"
                onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
              >
            </div>
            <span class="text-[10px] font-bold text-blue-700 uppercase">{{ $rel->published_year }}</span>
            <h3 class="text-xs font-bold text-slate-800 line-clamp-2 mt-1">
              {{ $rel->name }}
            </h3>
            <div class="mt-3 pt-2 border-t border-slate-100 flex gap-2">
              <a href="{{ route('katalog.baca', $rel) }}" class="flex-1 text-center rounded-lg bg-[#082b62] py-1.5 text-[11px] font-bold text-white hover:bg-blue-900 transition">
                Baca
              </a>
              <a href="{{ route('katalog.show', $rel) }}" class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-[11px] font-semibold text-slate-600 hover:bg-slate-50 transition">
                Detail
              </a>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  @endif

</div>
@endsection
