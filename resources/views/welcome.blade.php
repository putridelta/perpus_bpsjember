@extends('guest.layouts.app')

@section('title', 'Perpustakaan Digital BPS Kabupaten Jember - Publikasi Statistik Resmi')

@section('content')
<!-- Hero Section -->
<section id="beranda" class="relative pt-10 pb-16 md:pt-16 md:pb-24 overflow-hidden">
  <!-- Blue background illustration -->
  <div class="absolute inset-0 -z-10 h-[560px] w-full">
    <img 
      src="{{ asset('assets/images/bg-biru.svg') }}" 
      alt="Background Perpustakaan BPS" 
      class="h-full w-full object-cover"
    >
  </div>

  <div class="site-width grid items-center gap-10 lg:grid-cols-12">
    <!-- Left Hero Content -->
    <div class="lg:col-span-7 pt-4">
      <div class="mb-4 inline-flex items-center gap-2 rounded-full px-3.5 py-1 text-xs font-extrabold bg-blue-100 text-blue-900 border border-blue-200">
        <i data-lucide="award" class="h-3.5 w-3.5 text-blue-700"></i>
        <span>PERPUSTAKAAN DIGITAL RESMI BPS JEMBER</span>
      </div>

      <h1 class="text-3xl sm:text-4xl md:text-5xl font-black leading-tight text-white tracking-tight">
        Akses Publikasi Statistik Resmi & Terpercaya
      </h1>

      <p class="mt-4 max-w-xl text-sm md:text-base text-blue-50 leading-relaxed font-normal">
        Temukan data agregat, publikasi kecamatan dalam angka, indikator ekonomi regional (PDRB), kependudukan, serta buku statistik resmi Kabupaten Jember secara lengkap dan mudah dibaca.
      </p>

      <div class="mt-8 flex flex-wrap gap-4 items-center">
        <a 
          href="{{ route('katalog.index') }}" 
          class="inline-flex items-center gap-2 rounded-xl bg-yellow-400 px-6 py-3.5 text-sm font-extrabold text-slate-900 shadow-lg hover:bg-yellow-300 transition transform hover:-translate-y-0.5"
        >
          <i data-lucide="book-open" class="h-4 w-4"></i>
          <span>Jelajahi Daftar Katalog</span>
        </a>

        <a 
          href="#katalog" 
          class="inline-flex items-center gap-2 rounded-xl border border-white/40 bg-white/10 backdrop-blur-xs px-6 py-3.5 text-sm font-bold text-white hover:bg-white/20 transition"
        >
          <i data-lucide="search" class="h-4 w-4"></i>
          <span>Cari Publikasi</span>
        </a>
      </div>

      <!-- Quick Metrics -->
      <div class="mt-10 grid grid-cols-3 gap-4 max-w-lg border-t border-white/20 pt-6">
        <div>
          <div class="text-2xl sm:text-3xl font-black text-white">{{ $totalBooks }}</div>
          <div class="text-xs text-blue-200 mt-0.5">Buku Publikasi</div>
        </div>
        <div>
          <div class="text-2xl sm:text-3xl font-black text-white">{{ $totalCategories }}</div>
          <div class="text-xs text-blue-200 mt-0.5">Kategori Statistik</div>
        </div>
        <div>
          <div class="text-2xl sm:text-3xl font-black text-yellow-300">Gratis</div>
          <div class="text-xs text-blue-200 mt-0.5">Akses Terbuka</div>
        </div>
      </div>
    </div>

    <!-- Right Hero Art -->
    <div class="lg:col-span-5 hidden lg:block">
      <div class="relative rounded-3xl bg-white/10 backdrop-blur-md p-6 border border-white/20 shadow-2xl">
        <div class="flex items-center justify-between pb-4 border-b border-white/15">
          <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-red-400"></span>
            <span class="h-3 w-3 rounded-full bg-yellow-400"></span>
            <span class="h-3 w-3 rounded-full bg-green-400"></span>
          </div>
          <span class="text-xs font-bold text-blue-100 tracking-wider">PORTAL PERPUSTAKAAN BPS</span>
        </div>

        <div class="mt-4 flex gap-4 items-center">
          <div class="w-32 aspect-[3/4] rounded-xl overflow-hidden shadow-lg border border-white/20 shrink-0">
            <img 
              src="{{ asset('assets/images/cover-buku1.jpg') }}" 
              alt="Sampul Publikasi Terpilih" 
              class="w-full h-full object-cover"
            >
          </div>
          <div class="text-white text-xs space-y-2">
            <span class="rounded bg-yellow-400 text-slate-900 font-extrabold px-2 py-0.5 text-[10px] uppercase">
              Rekomendasi
            </span>
            <h4 class="font-extrabold text-sm leading-snug">Kabupaten Jember Dalam Angka 2026</h4>
            <p class="text-blue-100 line-clamp-3">Menyajikan data menyeluruh terkait geografi, sosial, kependudukan, hingga makro ekonomi Kabupaten Jember.</p>
            <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-1 text-yellow-300 font-bold hover:underline">
              <span>Buka di Katalog</span>
              <i data-lucide="arrow-right" class="h-3 w-3"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Search Section -->
<section id="katalog" class="pt-4 pb-8">
  <div class="site-width">
    <div class="rounded-2xl bg-white p-5 md:p-6 shadow-md border border-slate-200/90 -mt-6 relative z-20">
      <form action="{{ route('katalog.index') }}" method="GET" class="grid gap-3 md:grid-cols-[1fr_auto]">
        <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/60 px-4 focus-within:border-blue-600 focus-within:bg-white transition">
          <i data-lucide="search" class="h-5 w-5 text-slate-400"></i>
          <input 
            type="search" 
            name="search" 
            id="catalog-search"
            placeholder="Cari judul publikasi, nama kecamatan, PDRB, tahun terbit..." 
            class="h-12 w-full border-0 bg-transparent text-sm text-slate-800 placeholder:text-slate-400 outline-none"
          >
        </div>
        <button 
          type="submit" 
          class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#082b62] px-8 py-3 text-sm font-bold text-white shadow-sm hover:bg-[#114b9c] transition active:scale-95"
        >
          <i data-lucide="search" class="h-4 w-4"></i>
          <span>Cari di Katalog</span>
        </button>
      </form>
    </div>
  </div>
</section>

<!-- Kategori Populer -->
<section id="koleksi" class="py-8">
  <div class="site-width">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
      <div>
        <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Klasifikasi Data</span>
        <h2 class="text-2xl font-extrabold text-[#082b62] tracking-tight">Kategori Publikasi Statistik</h2>
        <p class="mt-1 text-xs md:text-sm text-slate-500">Pilih rumpun kategori untuk menemukan publikasi yang sesuai kebutuhan riset Anda.</p>
      </div>
      <a 
        href="{{ route('katalog.index') }}" 
        class="inline-flex items-center gap-1 text-xs font-bold text-[#1565c0] hover:underline underline-offset-4"
      >
        <span>Lihat Semua Katalog</span>
        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
      </a>
    </div>

    <!-- Category Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
      <!-- All Categories Card -->
      <a 
        href="{{ route('katalog.index') }}" 
        class="group flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-xs hover:border-blue-400 hover:shadow-md transition"
      >
        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-[#1565c0] group-hover:scale-110 transition">
          <i data-lucide="layout-grid" class="h-6 w-6"></i>
        </span>
        <span class="mt-3 block text-sm font-bold text-slate-800 group-hover:text-blue-700 transition">Semua Kategori</span>
        <span class="mt-0.5 block text-[11px] text-slate-500">{{ $totalBooks }} Publikasi</span>
      </a>

      @foreach($categories as $index => $cat)
        @php
          $icons = ['map-pin', 'trending-up', 'users', 'briefcase', 'book-open'];
          $icon = $icons[$index % count($icons)];
        @endphp
        <a 
          href="{{ route('katalog.index', ['kategori' => $cat->id]) }}" 
          class="group flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-xs hover:border-blue-400 hover:shadow-md transition"
        >
          <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 group-hover:scale-110 transition">
            <i data-lucide="{{ $icon }}" class="h-6 w-6"></i>
          </span>
          <span class="mt-3 block text-sm font-bold text-slate-800 group-hover:text-blue-700 transition truncate max-w-[150px]">
            {{ $cat->name }}
          </span>
          <span class="mt-0.5 block text-[11px] text-slate-500">{{ $cat->books_count }} Buku</span>
        </a>
      @endforeach
    </div>
  </div>
</section>

<!-- Featured Books (Koleksi Buku Populer) -->
<section class="py-8">
  <div class="site-width">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
      <div>
        <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Koleksi Terpopuler</span>
        <h2 class="text-2xl font-extrabold text-[#082b62] tracking-tight">Buku & Publikasi Terbaru</h2>
        <p class="mt-1 text-xs md:text-sm text-slate-500">Klik "Baca Sekarang" untuk membaca langsung dokumen publikasi resmi secara online.</p>
      </div>

      <a 
        href="{{ route('katalog.index') }}" 
        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs"
      >
        <span>Buka Seluruh Katalog ({{ $totalBooks }})</span>
        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
      </a>
    </div>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($featuredBooks as $book)
        <article class="group flex flex-col justify-between rounded-2xl border border-slate-200/90 bg-white shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
          
          <!-- Cover Container -->
          <div class="relative aspect-[3/4] w-full overflow-hidden bg-slate-100">
            <img 
              src="{{ $book->cover_url }}" 
              alt="{{ $book->name }}" 
              loading="lazy"
              class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
              onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
            >

            <!-- Badges -->
            <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
              <span class="rounded-md bg-[#082b62]/90 backdrop-blur-xs px-2.5 py-1 text-[11px] font-bold text-white shadow-xs">
                {{ $book->category?->name ?? 'Statistik' }}
              </span>
              <span class="rounded-md bg-white/95 backdrop-blur-xs px-2 py-0.5 text-[11px] font-extrabold text-[#082b62] shadow-xs">
                {{ $book->published_year }}
              </span>
            </div>

            <!-- Quick Action Hover Overlay -->
            <div class="absolute inset-0 bg-[#082b62]/75 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-4 gap-2.5 backdrop-blur-xs">
              <a 
                href="{{ route('katalog.baca', $book) }}" 
                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-yellow-400 px-4 py-2.5 text-xs font-extrabold text-[#082b62] shadow-md hover:bg-yellow-300 transition transform hover:scale-105"
              >
                <i data-lucide="book-open" class="h-4 w-4"></i>
                <span>Baca Buku Sekarang</span>
              </a>
              <button 
                type="button" 
                onclick="openBookDetailHome({{ $book->id }})"
                class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-white/90 px-4 py-2 text-xs font-bold text-slate-800 hover:bg-white transition"
              >
                <i data-lucide="info" class="h-4 w-4"></i>
                <span>Detail & Ringkasan</span>
              </button>
            </div>
          </div>

          <!-- Metadata -->
          <div class="flex flex-1 flex-col justify-between p-4 sm:p-5">
            <div>
              <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider block mb-1">
                {{ $book->category?->name }}
              </span>
              <h3 class="text-sm font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-[#1565c0] transition">
                <a href="{{ route('katalog.baca', $book) }}">
                  {{ $book->name }}
                </a>
              </h3>
              <p class="mt-2 text-xs text-slate-500 line-clamp-2 leading-relaxed">
                {{ $book->describe }}
              </p>
            </div>

            <!-- Bottom Actions -->
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2">
              <a 
                href="{{ route('katalog.baca', $book) }}" 
                class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#082b62] px-3.5 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#124b96] transition"
              >
                <i data-lucide="book-open" class="h-3.5 w-3.5"></i>
                <span>Baca</span>
              </a>

              <button 
                type="button" 
                onclick="openBookDetailHome({{ $book->id }})"
                class="rounded-xl border border-slate-200 p-2 text-slate-600 hover:bg-slate-50 hover:text-blue-700 transition" 
                title="Lihat Detail"
              >
                <i data-lucide="eye" class="h-4 w-4"></i>
              </button>
            </div>
          </div>

        </article>
      @endforeach
    </div>

    <!-- CTA Section to Full Catalog -->
    <div class="mt-12 text-center">
      <div class="inline-flex flex-col sm:flex-row items-center gap-4 rounded-3xl bg-blue-50/80 border border-blue-200/60 p-6 md:p-8">
        <div class="text-left">
          <h3 class="text-lg font-black text-[#082b62]">Ingin melihat seluruh publikasi statistik lainnya?</h3>
          <p class="text-xs md:text-sm text-slate-600 mt-1">Gunakan filter kategori lengkap, pencarian tahun terbit, dan urutan buku pada Daftar Katalog.</p>
        </div>
        <a 
          href="{{ route('katalog.index') }}" 
          class="shrink-0 inline-flex items-center gap-2 rounded-2xl bg-[#082b62] px-6 py-3.5 text-xs font-bold text-white shadow-md hover:bg-blue-900 transition"
        >
          <i data-lucide="library" class="h-4 w-4"></i>
          <span>Buka Daftar Katalog Lengkap</span>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="py-12 bg-white border-t border-slate-200/80">
  <div class="site-width">
    <div class="rounded-3xl p-8 md:p-12 text-white shadow-xl relative overflow-hidden" style="background: linear-gradient(115deg, rgb(8, 43, 98), rgb(18, 105, 191));">
      <!-- Decorative circle -->
      <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-white/5 pointer-events-none"></div>

      <div class="max-w-3xl relative z-10">
        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-yellow-300 mb-3 border border-white/15">
          <i data-lucide="building-2" class="h-3.5 w-3.5"></i>
          <span>TENTANG BPS KABUPATEN JEMBER</span>
        </div>

        <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white leading-tight">
          Menyediakan Data Statistik Berkualitas untuk Pembangunan Indonesia Maju
        </h2>

        <p class="mt-4 text-xs md:text-sm text-blue-100 leading-relaxed font-normal">
          Badan Pusat Statistik adalah Lembaga Pemerintah Non Kementerian yang bertanggung jawab langsung kepada Presiden Republik Indonesia berdasarkan Undang-Undang Nomor 16 Tahun 1997 tentang Statistik. Melalui Perpustakaan Digital ini, BPS Kabupaten Jember berkomitmen mempermudah akses bagi akademisi, peneliti, mahasiswa, pemerintah daerah, dan masyarakat umum dalam memperoleh data statistik yang valid, akurat, dan terpercaya.
        </p>

        <div class="mt-8 flex flex-wrap gap-4 items-center text-xs">
          <a 
            href="{{ route('katalog.index') }}" 
            class="inline-flex items-center gap-2 rounded-xl bg-yellow-400 px-5 py-3 font-extrabold text-slate-900 shadow-md hover:bg-yellow-300 transition"
          >
            <i data-lucide="book-marked" class="h-4 w-4"></i>
            <span>Mulai Jelajah Koleksi</span>
          </a>

          <a 
            href="https://jemberkab.bps.go.id" 
            target="_blank" 
            class="inline-flex items-center gap-2 rounded-xl border border-white/30 px-5 py-3 font-bold text-white hover:bg-white/10 transition"
          >
            <span>Kunjungi Web Resmi BPS Jember</span>
            <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Detail Modal for Homepage -->
<div id="homeDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#071d3a]/65 backdrop-blur-xs p-4" role="dialog" aria-modal="true">
  <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-3xl bg-white shadow-2xl p-6 sm:p-8">
    <button 
      type="button" 
      onclick="closeBookDetailHome()" 
      class="absolute top-5 right-5 rounded-full p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition"
      aria-label="Tutup"
    >
      <i data-lucide="x" class="h-5 w-5"></i>
    </button>

    <div id="homeModalLoading" class="py-12 text-center text-slate-500">
      <div class="mx-auto h-8 w-8 animate-spin rounded-full border-2 border-blue-600 border-t-transparent"></div>
      <p class="mt-3 text-xs">Memuat publikasi...</p>
    </div>

    <div id="homeModalContent" class="hidden flex-col sm:flex-row gap-6 items-start">
      <div class="w-full sm:w-48 shrink-0 aspect-[3/4] rounded-2xl overflow-hidden shadow-md bg-slate-100">
        <img id="hmCover" src="" alt="Cover Buku" class="w-full h-full object-cover">
      </div>

      <div class="flex-1 flex flex-col justify-between">
        <div>
          <div class="flex flex-wrap items-center gap-2 mb-2">
            <span id="hmCategory" class="rounded-full bg-blue-100 px-3 py-0.5 text-xs font-bold text-blue-800"></span>
            <span id="hmYear" class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700"></span>
          </div>

          <h3 id="hmTitle" class="text-xl font-extrabold text-[#082b62] leading-tight"></h3>

          <div class="mt-4 pt-3 border-t border-slate-100">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Sinopsis:</h4>
            <p id="hmDesc" class="text-xs text-slate-600 leading-relaxed"></p>
          </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3">
          <a 
            id="hmReadBtn" 
            href="#" 
            class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-[#082b62] px-5 py-3 text-xs font-bold text-white shadow-md hover:bg-blue-900 transition"
          >
            <i data-lucide="book-open" class="h-4 w-4"></i>
            <span>Baca Sekarang</span>
          </a>

          <a 
            id="hmPdfBtn" 
            href="#" 
            target="_blank" 
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-4 py-3 text-xs font-bold text-slate-700 hover:bg-slate-50 transition"
          >
            <i data-lucide="download" class="h-4 w-4"></i>
            <span>Unduh PDF</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const hmModal = document.getElementById('homeDetailModal');
  const hmLoading = document.getElementById('homeModalLoading');
  const hmContent = document.getElementById('homeModalContent');

  function openBookDetailHome(bookId) {
    if (!hmModal) return;
    hmModal.classList.remove('hidden');
    hmModal.classList.add('flex');
    hmLoading.classList.remove('hidden');
    hmContent.classList.add('hidden');
    hmContent.classList.remove('flex');
    document.body.classList.add('modal-open');

    fetch(`/katalog/${bookId}/api`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('hmCover').src = data.cover_url;
        document.getElementById('hmTitle').textContent = data.name;
        document.getElementById('hmCategory').textContent = data.category;
        document.getElementById('hmYear').textContent = 'Tahun ' + data.published_year;
        document.getElementById('hmDesc').textContent = data.describe;
        document.getElementById('hmReadBtn').href = data.read_url;
        document.getElementById('hmPdfBtn').href = data.pdf_url;

        hmLoading.classList.add('hidden');
        hmContent.classList.remove('hidden');
        hmContent.classList.add('flex');
        if (typeof lucide !== 'undefined') lucide.createIcons();
      })
      .catch(err => {
        console.error(err);
        closeBookDetailHome();
      });
  }

  function closeBookDetailHome() {
    if (!hmModal) return;
    hmModal.classList.add('hidden');
    hmModal.classList.remove('flex');
    document.body.classList.remove('modal-open');
  }

  if (hmModal) {
    hmModal.addEventListener('click', (e) => {
      if (e.target === hmModal) closeBookDetailHome();
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !hmModal.classList.contains('hidden')) {
        closeBookDetailHome();
      }
    });
  }
</script>
@endpush