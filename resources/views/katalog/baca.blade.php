@extends('guest.layouts.app')

@section('title', 'Membaca: ' . $book->name . ' - Perpustakaan Digital BPS Kabupaten Jember')

@section('content')
<div class="bg-slate-900 text-white border-b border-slate-800 sticky top-[68px] z-30 shadow-md">
  <div class="site-width py-3 flex flex-wrap items-center justify-between gap-3">
    
    <!-- Left Navigation & Title -->
    <div class="flex items-center gap-3 min-w-0">
      <a 
        href="{{ route('katalog.index') }}" 
        class="inline-flex items-center gap-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 px-3 py-1.5 text-xs font-semibold text-slate-200 transition shrink-0"
        title="Kembali ke Daftar Katalog"
      >
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        <span class="hidden sm:inline">Katalog</span>
      </a>

      <div class="min-w-0">
        <div class="flex items-center gap-2">
          <span class="rounded bg-blue-600/80 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">
            {{ $book->category?->name ?? 'Statistik' }}
          </span>
          <span class="text-xs text-slate-400">Tahun {{ $book->published_year }}</span>
        </div>
        <h1 class="text-sm md:text-base font-bold text-white truncate max-w-md md:max-w-xl">
          {{ $book->name }}
        </h1>
      </div>
    </div>

    <!-- Right Controls Toolbar -->
    <div class="flex items-center gap-2">
      <!-- Tab Controls -->
      <div class="inline-flex rounded-lg bg-slate-800 p-1 border border-slate-700 text-xs font-medium">
        <button 
          id="btnTabPdf" 
          type="button" 
          onclick="switchReaderTab('pdf')" 
          class="rounded-md px-3 py-1 bg-blue-600 text-white font-bold transition flex items-center gap-1.5 shadow-xs"
        >
          <i data-lucide="file-text" class="h-3.5 w-3.5"></i>
          <span>Dokumen PDF</span>
        </button>
        <button 
          id="btnTabOverview" 
          type="button" 
          onclick="switchReaderTab('overview')" 
          class="rounded-md px-3 py-1 text-slate-300 hover:text-white transition flex items-center gap-1.5"
        >
          <i data-lucide="book-open" class="h-3.5 w-3.5"></i>
          <span>Ringkasan Statistik</span>
        </button>
      </div>

      <!-- Fullscreen Toggle -->
      <button 
        type="button" 
        id="btnFullscreen" 
        onclick="toggleReaderFullscreen()" 
        class="rounded-lg bg-slate-800 hover:bg-slate-700 p-2 text-slate-200 transition" 
        title="Layar Penuh (Fullscreen)"
      >
        <i data-lucide="maximize" class="h-4 w-4"></i>
      </button>

      <!-- Download Button -->
      <a 
        href="{{ $book->pdf_url }}" 
        download="{{ \Illuminate\Support\Str::slug($book->name) }}.pdf"
        target="_blank"
        class="inline-flex items-center gap-1.5 rounded-lg bg-yellow-400 hover:bg-yellow-300 px-3 py-1.5 text-xs font-bold text-slate-900 transition shadow-xs"
        title="Download Publikasi Resmi"
      >
        <i data-lucide="download" class="h-3.5 w-3.5"></i>
        <span class="hidden md:inline">Unduh PDF</span>
      </a>
    </div>

  </div>
</div>

<div class="bg-slate-100 min-h-[calc(100vh-140px)] py-6">
  <div class="site-width">
    
    <!-- Grid Reader Shell -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
      
      <!-- MAIN READER CONTAINER (Col 8/12) -->
      <div id="readerMainArea" class="lg:col-span-8 flex flex-col rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden transition-all duration-300">
        
        <!-- Reader PDF Tab -->
        <div id="tabPdfContent" class="w-full flex flex-col">
          <div class="bg-slate-50 px-4 py-2 border-b border-slate-200 flex items-center justify-between text-xs text-slate-600">
            <div class="flex items-center gap-2">
              <span class="inline-block h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
              <span class="font-semibold text-slate-700">Penampil Dokumen Digital BPS</span>
            </div>
            <div class="flex items-center gap-3">
              <a href="{{ $book->pdf_url }}" target="_blank" class="hover:text-blue-700 font-medium flex items-center gap-1">
                <i data-lucide="external-link" class="h-3 w-3"></i>
                <span>Buka di Tab Baru</span>
              </a>
            </div>
          </div>

          <!-- Embedded PDF Frame -->
          <div class="relative w-full bg-slate-800" style="height: 760px;">
            <object 
              data="{{ $book->pdf_url }}#toolbar=1&navpanes=1&scrollbar=1" 
              type="application/pdf" 
              class="w-full h-full"
            >
              <!-- Fallback iframe -->
              <iframe 
                src="{{ $book->pdf_url }}" 
                class="w-full h-full border-0"
                title="Penampil PDF {{ $book->name }}"
              >
                <div class="p-8 text-center bg-white text-slate-700">
                  <p class="mb-4">Browser Anda tidak mendukung preview PDF langsung.</p>
                  <a href="{{ $book->pdf_url }}" target="_blank" class="rounded-xl bg-blue-700 px-4 py-2 text-white font-bold text-xs">
                    Unduh dan Buka PDF
                  </a>
                </div>
              </iframe>
            </object>
          </div>
        </div>

        <!-- Reader Overview Tab -->
        <div id="tabOverviewContent" class="hidden p-6 md:p-8">
          <div class="border-b border-slate-200 pb-5 mb-6">
            <span class="text-xs font-bold uppercase text-blue-700 tracking-wider">Publikasi Statistik Resmi</span>
            <h2 class="text-2xl font-black text-[#082b62] mt-1">{{ $book->name }}</h2>
            <div class="mt-3 flex flex-wrap gap-2 text-xs">
              <span class="rounded-full bg-blue-50 text-blue-800 px-3 py-1 font-semibold border border-blue-100">
                Kategori: {{ $book->category?->name ?? 'Statistik Terapan' }}
              </span>
              <span class="rounded-full bg-slate-100 text-slate-700 px-3 py-1 font-semibold">
                Tahun Rilis: {{ $book->published_year }}
              </span>
              <span class="rounded-full bg-emerald-50 text-emerald-800 px-3 py-1 font-semibold border border-emerald-100">
                Penerbit: BPS Kabupaten Jember
              </span>
            </div>
          </div>

          <!-- Synopsis / Description -->
          <div class="prose max-w-none text-slate-700 text-sm leading-relaxed mb-8">
            <h3 class="text-base font-extrabold text-[#082b62] mb-2 flex items-center gap-2">
              <i data-lucide="align-left" class="h-4 w-4 text-blue-600"></i>
              <span>Sinopsis & Ruang Lingkup Data</span>
            </h3>
            <p>{{ $book->describe }}</p>
            <p class="mt-3">
              Publikasi ini menyajikan himpunan data statistik yang bersumber dari survei berkala Badan Pusat Statistik serta data kompilasi dari dinas dan instansi terkait di lingkungan Pemerintah Kabupaten Jember. Disajikan dalam bentuk tabel, grafik, dan ulasan singkat untuk memudahkan pengguna data dalam mencermati dinamika pembangunan wilayah.
            </p>
          </div>

          <!-- Highlight Indikator Makro Kabupaten Jember -->
          <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-slate-50 border border-blue-100 p-6 mb-8">
            <h3 class="text-sm font-extrabold text-[#082b62] uppercase tracking-wider mb-4 flex items-center gap-2">
              <i data-lucide="bar-chart-3" class="h-4 w-4 text-blue-600"></i>
              <span>Rangkuman Indikator Makro Kabupaten Jember</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div class="rounded-xl bg-white p-4 border border-blue-100/60 shadow-xs">
                <span class="text-xs text-slate-500 font-medium">Jumlah Penduduk</span>
                <div class="text-xl font-extrabold text-[#082b62] mt-1">2,58 Juta Jiwa</div>
                <span class="text-[11px] text-emerald-600 font-medium mt-1 inline-block">+0.85% laju tahunan</span>
              </div>
              <div class="rounded-xl bg-white p-4 border border-blue-100/60 shadow-xs">
                <span class="text-xs text-slate-500 font-medium">Indeks Pembangunan Manusia</span>
                <div class="text-xl font-extrabold text-[#082b62] mt-1">70,82 (Tinggi)</div>
                <span class="text-[11px] text-blue-600 font-medium mt-1 inline-block">Umur Harapan Hidup: 72,15 th</span>
              </div>
              <div class="rounded-xl bg-white p-4 border border-blue-100/60 shadow-xs">
                <span class="text-xs text-slate-500 font-medium">Pertumbuhan Ekonomi</span>
                <div class="text-xl font-extrabold text-[#082b62] mt-1">5,15%</div>
                <span class="text-[11px] text-blue-600 font-medium mt-1 inline-block">PDRB ADHB: Rp 92,45 Triliun</span>
              </div>
            </div>
          </div>

          <!-- Struktur Bab Publikasi -->
          <div>
            <h3 class="text-base font-extrabold text-[#082b62] mb-3 flex items-center gap-2">
              <i data-lucide="list-ordered" class="h-4 w-4 text-blue-600"></i>
              <span>Struktur & Sistematika Isi Buku</span>
            </h3>
            <div class="grid gap-2 text-xs text-slate-700">
              <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">1</span>
                <div>
                  <div class="font-bold text-slate-800">Bab I: Geografi dan Iklim</div>
                  <div class="text-slate-500">Letak astronomis, batas wilayah administrasi, topografi, dan curah hujan.</div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">2</span>
                <div>
                  <div class="font-bold text-slate-800">Bab II: Pemerintahan & Tata Kelola Wilayah</div>
                  <div class="text-slate-500">Jumlah desa, kelurahan, aparatur pemerintahan, dan keuangan daerah.</div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">3</span>
                <div>
                  <div class="font-bold text-slate-800">Bab III: Kependudukan & Ketenagakerjaan</div>
                  <div class="text-slate-500">Piramida penduduk, rasio jenis kelamin, angkatan kerja, dan tingkat pengangguran.</div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">4</span>
                <div>
                  <div class="font-bold text-slate-800">Bab IV: Sosial dan Kesejahteraan Rakyat</div>
                  <div class="text-slate-500">Pendidikan formal, fasilitas kesehatan, jaminan sosial, dan kemiskinan.</div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">5</span>
                <div>
                  <div class="font-bold text-slate-800">Bab V: Pertanian, Perkebunan & Perikanan</div>
                  <div class="text-slate-500">Produksi padi, palawija, kopi, tembakau, dan komoditas peternakan.</div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">6</span>
                <div>
                  <div class="font-bold text-slate-800">Bab VI: Perdagangan, Industri & Ekonomi Daerah</div>
                  <div class="text-slate-500">PDRB, transaksi UMKM, pasar rakyat, dan indikator harga konsumen.</div>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-8 pt-6 border-t border-slate-200 flex justify-end">
            <button 
              type="button" 
              onclick="switchReaderTab('pdf')" 
              class="inline-flex items-center gap-2 rounded-xl bg-[#082b62] px-6 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-blue-900 transition"
            >
              <i data-lucide="file-text" class="h-4 w-4"></i>
              <span>Kembali ke Dokumen Lengkap PDF</span>
            </button>
          </div>
        </div>

      </div>

      <!-- SIDEBAR METADATA & RELATED (Col 4/12) -->
      <div class="lg:col-span-4 flex flex-col gap-6">
        
        <!-- Book Information Card -->
        <div class="rounded-2xl bg-white border border-slate-200/90 p-5 shadow-xs">
          <div class="flex gap-4 items-start mb-4">
            <div class="w-24 shrink-0 aspect-[3/4] rounded-xl overflow-hidden shadow-sm bg-slate-100 border border-slate-200">
              <img 
                src="{{ $book->cover_url }}" 
                alt="{{ $book->name }}" 
                class="w-full h-full object-cover"
                onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
              >
            </div>
            <div>
              <span class="rounded bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-800 uppercase">
                {{ $book->category?->name ?? 'Statistik' }}
              </span>
              <h3 class="text-sm font-bold text-slate-900 leading-snug mt-1">
                {{ $book->name }}
              </h3>
              <p class="text-xs text-slate-500 mt-1">Tahun Publikasi: <strong>{{ $book->published_year }}</strong></p>
            </div>
          </div>

          <div class="space-y-2.5 text-xs border-t border-slate-100 pt-3 text-slate-600">
            <div class="flex justify-between">
              <span class="text-slate-400">Penerbit:</span>
              <span class="font-semibold text-slate-700">BPS Kab. Jember</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-400">Bahasa:</span>
              <span class="font-semibold text-slate-700">Bahasa Indonesia</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-400">Format:</span>
              <span class="font-semibold text-slate-700">Digital PDF Resmi</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-400">Akses:</span>
              <span class="font-semibold text-emerald-600">Publik Terbuka</span>
            </div>
          </div>

          <div class="mt-5 pt-3 border-t border-slate-100 flex flex-col gap-2">
            <a 
              href="{{ $book->pdf_url }}" 
              target="_blank" 
              class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition"
            >
              <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
              <span>Buka di Layar Penuh</span>
            </a>
            <a 
              href="{{ route('katalog.index') }}" 
              class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-100 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-200 transition"
            >
              <i data-lucide="grid" class="h-3.5 w-3.5"></i>
              <span>Cari Publikasi Lain</span>
            </a>
          </div>
        </div>

        <!-- Related Books in Same Category -->
        @if(isset($relatedBooks) && $relatedBooks->count() > 0)
          <div class="rounded-2xl bg-white border border-slate-200/90 p-5 shadow-xs">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-1.5">
              <i data-lucide="bookmark" class="h-4 w-4 text-blue-600"></i>
              <span>Publikasi Terkait</span>
            </h3>

            <div class="space-y-3">
              @foreach($relatedBooks as $related)
                <a 
                  href="{{ route('katalog.baca', $related) }}" 
                  class="group flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-200"
                >
                  <div class="w-12 h-16 shrink-0 rounded-lg overflow-hidden bg-slate-100 border border-slate-200">
                    <img 
                      src="{{ $related->cover_url }}" 
                      alt="{{ $related->name }}" 
                      class="w-full h-full object-cover group-hover:scale-105 transition"
                      onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
                    >
                  </div>
                  <div class="min-w-0">
                    <span class="text-[10px] text-blue-600 font-bold block">{{ $related->published_year }}</span>
                    <h4 class="text-xs font-bold text-slate-800 truncate group-hover:text-blue-700 transition">
                      {{ $related->name }}
                    </h4>
                    <span class="text-[11px] text-slate-400 block truncate">
                      {{ $related->category?->name }}
                    </span>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        @endif

        <!-- Help / PST BPS Box -->
        <div class="rounded-2xl bg-[#082b62] text-white p-5 shadow-xs">
          <div class="flex items-center gap-2 mb-2 text-yellow-300 font-bold text-xs">
            <i data-lucide="headphones" class="h-4 w-4"></i>
            <span>Butuh Data Spesifik?</span>
          </div>
          <p class="text-xs text-blue-100 leading-relaxed">
            Kunjungi Pelayanan Statistik Terpadu (PST) BPS Kabupaten Jember di Jl. Kartini No. 19 atau akses portal online resmi BPS Jember.
          </p>
          <a 
            href="https://jemberkab.bps.go.id" 
            target="_blank" 
            class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-yellow-300 hover:text-yellow-200 underline underline-offset-4"
          >
            <span>Kunjungi Web Resmi BPS Jember</span>
            <i data-lucide="external-link" class="h-3 w-3"></i>
          </a>
        </div>

      </div>

    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
  function switchReaderTab(tab) {
    const btnPdf = document.getElementById('btnTabPdf');
    const btnOverview = document.getElementById('btnTabOverview');
    const tabPdf = document.getElementById('tabPdfContent');
    const tabOverview = document.getElementById('tabOverviewContent');

    if (tab === 'pdf') {
      tabPdf.classList.remove('hidden');
      tabOverview.classList.add('hidden');
      btnPdf.classList.add('bg-blue-600', 'text-white', 'font-bold', 'shadow-xs');
      btnPdf.classList.remove('text-slate-300');
      btnOverview.classList.remove('bg-blue-600', 'text-white', 'font-bold', 'shadow-xs');
      btnOverview.classList.add('text-slate-300');
    } else {
      tabPdf.classList.add('hidden');
      tabOverview.classList.remove('hidden');
      btnOverview.classList.add('bg-blue-600', 'text-white', 'font-bold', 'shadow-xs');
      btnOverview.classList.remove('text-slate-300');
      btnPdf.classList.remove('bg-blue-600', 'text-white', 'font-bold', 'shadow-xs');
      btnPdf.classList.add('text-slate-300');
    }
  }

  function toggleReaderFullscreen() {
    const area = document.getElementById('readerMainArea');
    if (!document.fullscreenElement) {
      if (area.requestFullscreen) {
        area.requestFullscreen();
      } else if (area.webkitRequestFullscreen) {
        area.webkitRequestFullscreen();
      } else if (area.msRequestFullscreen) {
        area.msRequestFullscreen();
      }
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      }
    }
  }
</script>
@endpush
