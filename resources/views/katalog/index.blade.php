@extends('guest.layouts.app')

@section('title', 'Daftar Katalog Publikasi - Perpustakaan Digital BPS Kabupaten Jember')

@section('content')
<div class="bg-gradient-to-b from-[#082b62] to-[#0f4c9c] text-white py-12 md:py-16">
  <div class="site-width">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-blue-200 mb-4" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
        <i data-lucide="home" class="h-3.5 w-3.5"></i>
        <span>Beranda</span>
      </a>
      <i data-lucide="chevron-right" class="h-3.5 w-3.5 text-blue-300/60"></i>
      <span class="text-white font-medium">Daftar Katalog</span>
    </nav>

    <div class="max-w-3xl">
      <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1 text-xs font-semibold text-blue-200 backdrop-blur-xs mb-3 border border-white/15">
        <i data-lucide="library" class="h-3.5 w-3.5 text-yellow-400"></i>
        <span>DAFTAR KATALOG PERPUSTAKAAN</span>
      </div>
      <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight">
        Katalog Publikasi & Buku Statistik
      </h1>
      <p class="mt-3 text-sm md:text-base text-blue-100 leading-relaxed">
        Temukan seluruh publikasi statistik resmi Kabupaten Jember: data kecamatan dalam angka, indikator ekonomi regional, statistik kependudukan, hingga analisis isu terkini.
      </p>
    </div>

    <!-- Quick Stats in Hero -->
    <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-3">
      <div class="rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 p-3.5">
        <span class="text-xs text-blue-200 font-medium">Total Publikasi</span>
        <div class="mt-1 text-2xl font-extrabold text-white">{{ $books->total() }}</div>
      </div>
      <div class="rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 p-3.5">
        <span class="text-xs text-blue-200 font-medium">Kategori Statistik</span>
        <div class="mt-1 text-2xl font-extrabold text-white">{{ $categories->count() }}</div>
      </div>
      <div class="rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 p-3.5">
        <span class="text-xs text-blue-200 font-medium">Tahun Terbit</span>
        <div class="mt-1 text-2xl font-extrabold text-white">{{ $years->first() ?? date('Y') }}</div>
      </div>
      <div class="rounded-xl bg-white/10 backdrop-blur-xs border border-white/10 p-3.5">
        <span class="text-xs text-blue-200 font-medium">Akses Baca</span>
        <div class="mt-1 text-xl font-extrabold text-yellow-300">100% Gratis</div>
      </div>
    </div>
  </div>
</div>

<div class="site-width py-8">
  <!-- Search & Filter Controls -->
  <div class="rounded-2xl bg-white p-5 md:p-6 shadow-sm border border-slate-200/80 mb-8">
    <form method="GET" action="{{ route('katalog.index') }}" id="filterForm">
      <div class="grid gap-4 md:grid-cols-12 items-end">
        
        <!-- Search Input -->
        <div class="md:col-span-5">
          <label for="search" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
            Pencarian Judul / Kata Kunci
          </label>
          <div class="relative flex items-center">
            <i data-lucide="search" class="absolute left-3.5 h-4 w-4 text-slate-400"></i>
            <input 
              type="text" 
              id="search" 
              name="search" 
              value="{{ $search }}" 
              placeholder="Cari kecamatan, PDRB, tahun, topik..." 
              class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-10 text-sm text-slate-800 placeholder:text-slate-400 focus:border-[#1565c0] focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
            >
            @if(!empty($search))
              <a href="{{ route('katalog.index', array_merge(request()->except('search'), ['search' => ''])) }}" class="absolute right-3 text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="h-4 w-4"></i>
              </a>
            @endif
          </div>
        </div>

        <!-- Category Dropdown -->
        <div class="md:col-span-3">
          <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
            Kategori Publikasi
          </label>
          <div class="relative">
            <select 
              id="kategori" 
              name="kategori" 
              onchange="document.getElementById('filterForm').submit()"
              class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-3.5 pr-8 text-sm text-slate-800 focus:border-[#1565c0] focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
            >
              <option value="all" {{ $selectedCategory == 'all' ? 'selected' : '' }}>Semua Kategori ({{ $categories->sum('books_count') }})</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ (string)$selectedCategory === (string)$cat->id ? 'selected' : '' }}>
                  {{ $cat->name }} ({{ $cat->books_count }})
                </option>
              @endforeach
            </select>
            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-3 h-4 w-4 text-slate-400"></i>
          </div>
        </div>

        <!-- Year Filter -->
        <div class="md:col-span-2">
          <label for="tahun" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
            Tahun Terbit
          </label>
          <div class="relative">
            <select 
              id="tahun" 
              name="tahun" 
              onchange="document.getElementById('filterForm').submit()"
              class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-3.5 pr-8 text-sm text-slate-800 focus:border-[#1565c0] focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
            >
              <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>Semua Tahun</option>
              @foreach($years as $yr)
                <option value="{{ $yr }}" {{ (string)$selectedYear === (string)$yr ? 'selected' : '' }}>{{ $yr }}</option>
              @endforeach
            </select>
            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-3 h-4 w-4 text-slate-400"></i>
          </div>
        </div>

        <!-- Sort Filter -->
        <div class="md:col-span-2">
          <label for="sort" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
            Urutkan
          </label>
          <div class="relative">
            <select 
              id="sort" 
              name="sort" 
              onchange="document.getElementById('filterForm').submit()"
              class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-3.5 pr-8 text-sm text-slate-800 focus:border-[#1565c0] focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
            >
              <option value="terbaru" {{ $sort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
              <option value="terlama" {{ $sort == 'terlama' ? 'selected' : '' }}>Terlama</option>
              <option value="judul_asc" {{ $sort == 'judul_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
              <option value="judul_desc" {{ $sort == 'judul_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
            </select>
            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-3 h-4 w-4 text-slate-400"></i>
          </div>
        </div>
      </div>

      <!-- Quick Category Pills -->
      <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center gap-2">
        <span class="text-xs font-semibold text-slate-500 mr-1">Kategori:</span>
        <a 
          href="{{ route('katalog.index', array_merge(request()->except(['kategori', 'page']), ['kategori' => 'all'])) }}"
          class="rounded-full px-3 py-1 text-xs font-semibold transition {{ $selectedCategory == 'all' ? 'bg-[#082b62] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
        >
          Semua
        </a>
        @foreach($categories as $cat)
          <a 
            href="{{ route('katalog.index', array_merge(request()->except(['kategori', 'page']), ['kategori' => $cat->id])) }}"
            class="rounded-full px-3 py-1 text-xs font-semibold transition {{ (string)$selectedCategory === (string)$cat->id ? 'bg-[#082b62] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
          >
            {{ $cat->name }} <span class="opacity-75">({{ $cat->books_count }})</span>
          </a>
        @endforeach

        @if(!empty($search) || $selectedCategory != 'all' || $selectedYear != 'all' || $sort != 'terbaru')
          <a href="{{ route('katalog.index') }}" class="ml-auto inline-flex items-center gap-1 text-xs font-bold text-red-600 hover:text-red-700 transition">
            <i data-lucide="rotate-ccw" class="h-3 w-3"></i>
            <span>Reset Filter</span>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Catalog Header & View Controls -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
      <h2 class="text-xl font-extrabold text-[#082b62] flex items-center gap-2">
        <span>Daftar Publikasi BPS</span>
        <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-800">
          {{ $books->total() }} Buku
        </span>
      </h2>
      <p class="text-xs text-slate-500 mt-1">
        @if(!empty($search))
          Hasil pencarian untuk "<span class="font-semibold text-slate-700">{{ $search }}</span>"
        @else
          Menampilkan koleksi buku statistik dan publikasi resmi
        @endif
      </p>
    </div>

    <!-- Layout Switcher -->
    <div class="flex items-center gap-2 self-end sm:self-auto">
      <span class="text-xs text-slate-400 font-medium">Tampilan:</span>
      <div class="inline-flex rounded-lg border border-slate-200 bg-white p-0.5">
        <button id="viewGridBtn" type="button" class="rounded-md p-1.5 text-blue-700 bg-blue-50 transition" title="Tampilan Grid">
          <i data-lucide="layout-grid" class="h-4 w-4"></i>
        </button>
        <button id="viewListBtn" type="button" class="rounded-md p-1.5 text-slate-400 hover:text-slate-600 transition" title="Tampilan List">
          <i data-lucide="list" class="h-4 w-4"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Book Items (Grid View) -->
  <div id="catalogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse($books as $book)
      <article class="group flex flex-col rounded-2xl border border-slate-200/80 bg-white shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
        
        <!-- Book Cover Container -->
        <div class="relative aspect-[3/4] w-full overflow-hidden bg-slate-100">
          <img 
            src="{{ $book->cover_url }}" 
            alt="{{ $book->name }}" 
            loading="lazy"
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
            onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
          >
          
          <!-- Category & Year Overlay Badges -->
          <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
            <span class="rounded-md bg-[#082b62]/90 backdrop-blur-xs px-2.5 py-1 text-[11px] font-bold text-white shadow-xs">
              {{ $book->category?->name ?? 'Statistik' }}
            </span>
            <span class="rounded-md bg-white/95 backdrop-blur-xs px-2 py-0.5 text-[11px] font-extrabold text-[#082b62] shadow-xs">
              {{ $book->published_year }}
            </span>
          </div>

          <!-- Quick Read Hover Overlay -->
          <div class="absolute inset-0 bg-[#082b62]/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-4 gap-2 backdrop-blur-xs">
            <a 
              href="{{ route('katalog.baca', $book) }}" 
              class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-yellow-400 px-4 py-2.5 text-xs font-extrabold text-[#082b62] shadow-md hover:bg-yellow-300 transition transform hover:scale-105"
            >
              <i data-lucide="book-open" class="h-4 w-4"></i>
              <span>Baca Buku Sekarang</span>
            </a>
            <button 
              type="button" 
              onclick="openBookDetail({{ $book->id }})"
              class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-white/90 px-4 py-2 text-xs font-bold text-slate-800 hover:bg-white transition"
            >
              <i data-lucide="info" class="h-4 w-4"></i>
              <span>Ringkasan & Detail</span>
            </button>
          </div>
        </div>

        <!-- Book Metadata -->
        <div class="flex flex-1 flex-col justify-between p-4 sm:p-5">
          <div>
            <div class="flex items-center gap-1.5 text-[11px] font-bold text-blue-700 uppercase tracking-wider mb-1.5">
              <i data-lucide="layers" class="h-3 w-3"></i>
              <span>{{ $book->category?->name ?? 'Publikasi BPS' }}</span>
            </div>
            
            <h3 class="text-sm font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-[#1565c0] transition">
              <a href="{{ route('katalog.baca', $book) }}">
                {{ $book->name }}
              </a>
            </h3>

            <p class="mt-2 text-xs text-slate-500 line-clamp-2 leading-relaxed">
              {{ $book->describe }}
            </p>
          </div>

          <!-- Action Buttons Bottom -->
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
              onclick="openBookDetail({{ $book->id }})" 
              class="rounded-xl border border-slate-200 p-2 text-slate-600 hover:bg-slate-50 hover:text-blue-700 transition" 
              title="Lihat Detail Buku"
            >
              <i data-lucide="eye" class="h-4 w-4"></i>
            </button>
          </div>

        </div>
      </article>
    @empty
      <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-50 text-blue-600 mb-4">
          <i data-lucide="search-x" class="h-7 w-7"></i>
        </div>
        <h3 class="text-base font-extrabold text-slate-800">Tidak ada buku yang ditemukan</h3>
        <p class="mt-1 text-xs text-slate-500 max-w-sm mx-auto">
          Tidak ditemukan publikasi statistik dengan kriteria pencarian Anda. Coba gunakan kata kunci lain atau reset filter.
        </p>
        <a href="{{ route('katalog.index') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#082b62] px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-blue-900 transition">
          <i data-lucide="rotate-ccw" class="h-3.5 w-3.5"></i>
          <span>Lihat Seluruh Katalog</span>
        </a>
      </div>
    @endforelse
  </div>

  <!-- Book Items (List View - Hidden by default) -->
  <div id="catalogList" class="hidden flex-col gap-4">
    @foreach($books as $book)
      <article class="flex flex-col sm:flex-row items-center gap-5 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-xs hover:shadow-md transition">
        <div class="w-full sm:w-28 shrink-0 aspect-[3/4] rounded-xl overflow-hidden bg-slate-100">
          <img 
            src="{{ $book->cover_url }}" 
            alt="{{ $book->name }}" 
            class="w-full h-full object-cover"
            onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
          >
        </div>
        <div class="flex-1 w-full flex flex-col justify-between">
          <div>
            <div class="flex items-center gap-2 mb-1.5">
              <span class="rounded-md bg-blue-100 px-2.5 py-0.5 text-[11px] font-bold text-blue-800">
                {{ $book->category?->name ?? 'Statistik' }}
              </span>
              <span class="text-xs text-slate-400">&bull;</span>
              <span class="text-xs font-semibold text-slate-600">
                Tahun Terbit: {{ $book->published_year }}
              </span>
            </div>
            <h3 class="text-base font-bold text-slate-900 leading-snug hover:text-blue-700 transition">
              <a href="{{ route('katalog.baca', $book) }}">{{ $book->name }}</a>
            </h3>
            <p class="mt-1.5 text-xs text-slate-500 leading-relaxed line-clamp-2">
              {{ $book->describe }}
            </p>
          </div>

          <div class="mt-4 flex flex-wrap items-center gap-3">
            <a 
              href="{{ route('katalog.baca', $book) }}" 
              class="inline-flex items-center gap-1.5 rounded-xl bg-[#082b62] px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#124b96] transition"
            >
              <i data-lucide="book-open" class="h-3.5 w-3.5"></i>
              <span>Baca Buku</span>
            </a>
            <button 
              type="button" 
              onclick="openBookDetail({{ $book->id }})" 
              class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition"
            >
              <i data-lucide="info" class="h-3.5 w-3.5"></i>
              <span>Detail Informasi</span>
            </button>
            <a 
              href="{{ $book->pdf_url }}" 
              target="_blank" 
              class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition"
            >
              <i data-lucide="download" class="h-3.5 w-3.5"></i>
              <span>Download PDF</span>
            </a>
          </div>
        </div>
      </article>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-10">
    {{ $books->links() }}
  </div>
</div>

<!-- Book Detail Modal -->
<div id="bookDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#071d3a]/65 backdrop-blur-xs p-4" role="dialog" aria-modal="true">
  <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-3xl bg-white shadow-2xl p-6 sm:p-8">
    <button 
      type="button" 
      onclick="closeBookDetail()" 
      class="absolute top-5 right-5 rounded-full p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition"
      aria-label="Tutup Detail"
    >
      <i data-lucide="x" class="h-5 w-5"></i>
    </button>

    <div id="modalLoading" class="py-12 text-center text-slate-500">
      <div class="mx-auto h-8 w-8 animate-spin rounded-full border-2 border-blue-600 border-t-transparent"></div>
      <p class="mt-3 text-xs">Memuat data publikasi...</p>
    </div>

    <div id="modalContent" class="hidden flex-col sm:flex-row gap-6 items-start">
      <!-- Cover -->
      <div class="w-full sm:w-48 shrink-0 aspect-[3/4] rounded-2xl overflow-hidden shadow-md bg-slate-100">
        <img id="mCover" src="" alt="Cover Buku" class="w-full h-full object-cover">
      </div>

      <!-- Info -->
      <div class="flex-1 flex flex-col justify-between">
        <div>
          <div class="flex flex-wrap items-center gap-2 mb-2">
            <span id="mCategory" class="rounded-full bg-blue-100 px-3 py-0.5 text-xs font-bold text-blue-800"></span>
            <span id="mYear" class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700"></span>
          </div>

          <h3 id="mTitle" class="text-xl font-extrabold text-[#082b62] leading-tight"></h3>

          <div class="mt-4 pt-3 border-t border-slate-100">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Sinopsis / Deskripsi:</h4>
            <p id="mDesc" class="text-xs text-slate-600 leading-relaxed"></p>
          </div>

          <div class="mt-4 rounded-xl bg-slate-50 border border-slate-100 p-3 text-xs text-slate-500">
            <div class="flex items-center gap-2 text-slate-700 font-semibold mb-1">
              <i data-lucide="shield-check" class="h-4 w-4 text-emerald-600"></i>
              <span>Publikasi Resmi BPS</span>
            </div>
            <p>Data bersumber dari Badan Pusat Statistik Kabupaten Jember dan instansi sektoral terkait.</p>
          </div>
        </div>

        <!-- Modal Actions -->
        <div class="mt-6 pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3">
          <a 
            id="mReadBtn" 
            href="#" 
            class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-[#082b62] px-5 py-3 text-xs font-bold text-white shadow-md hover:bg-blue-900 transition"
          >
            <i data-lucide="book-open" class="h-4 w-4"></i>
            <span>Buka & Baca Sekarang</span>
          </a>

          <a 
            id="mPdfBtn" 
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
  // Grid / List Toggle
  const gridBtn = document.getElementById('viewGridBtn');
  const listBtn = document.getElementById('viewListBtn');
  const catGrid = document.getElementById('catalogGrid');
  const catList = document.getElementById('catalogList');

  if (gridBtn && listBtn) {
    gridBtn.addEventListener('click', () => {
      catGrid.classList.remove('hidden');
      catList.classList.add('hidden');
      catList.classList.remove('flex');
      gridBtn.classList.add('bg-blue-50', 'text-blue-700');
      gridBtn.classList.remove('text-slate-400');
      listBtn.classList.remove('bg-blue-50', 'text-blue-700');
      listBtn.classList.add('text-slate-400');
    });

    listBtn.addEventListener('click', () => {
      catGrid.classList.add('hidden');
      catList.classList.remove('hidden');
      catList.classList.add('flex');
      listBtn.classList.add('bg-blue-50', 'text-blue-700');
      listBtn.classList.remove('text-slate-400');
      gridBtn.classList.remove('bg-blue-50', 'text-blue-700');
      gridBtn.classList.add('text-slate-400');
    });
  }

  // Modal logic
  const detailModal = document.getElementById('bookDetailModal');
  const modalLoading = document.getElementById('modalLoading');
  const modalContent = document.getElementById('modalContent');

  function openBookDetail(bookId) {
    if (!detailModal) return;
    detailModal.classList.remove('hidden');
    detailModal.classList.add('flex');
    modalLoading.classList.remove('hidden');
    modalContent.classList.add('hidden');
    modalContent.classList.remove('flex');
    document.body.classList.add('modal-open');

    fetch(`/katalog/${bookId}/api`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('mCover').src = data.cover_url;
        document.getElementById('mTitle').textContent = data.name;
        document.getElementById('mCategory').textContent = data.category;
        document.getElementById('mYear').textContent = 'Tahun ' + data.published_year;
        document.getElementById('mDesc').textContent = data.describe;
        document.getElementById('mReadBtn').href = data.read_url;
        document.getElementById('mPdfBtn').href = data.pdf_url;

        modalLoading.classList.add('hidden');
        modalContent.classList.remove('hidden');
        modalContent.classList.add('flex');
        if (typeof lucide !== 'undefined') lucide.createIcons();
      })
      .catch(err => {
        console.error(err);
        closeBookDetail();
      });
  }

  function closeBookDetail() {
    if (!detailModal) return;
    detailModal.classList.add('hidden');
    detailModal.classList.remove('flex');
    document.body.classList.remove('modal-open');
  }

  if (detailModal) {
    detailModal.addEventListener('click', (e) => {
      if (e.target === detailModal) closeBookDetail();
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !detailModal.classList.contains('hidden')) {
        closeBookDetail();
      }
    });
  }
</script>
@endpush
