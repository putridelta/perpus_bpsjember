<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Perpustakaan Digital BPS Kabupaten Jember - Akses Publikasi Statistik Resmi, Data, Laporan, dan Buku Statistik Daerah.">
  <title>@yield('title', 'Perpustakaan Digital BPS Kabupaten Jember')</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo-bps.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <script src="https://unpkg.com/lucide@latest"></script>
  @vite(['resources/css/app.css'])
  @stack('styles')
</head>

<body style="background: rgb(248, 251, 255); font-family: 'Plus Jakarta Sans', sans-serif;">
  <div class="page-shell min-h-screen flex flex-col justify-between">
    @include('guest.layouts.partials.header-landing')
    
    <main class="flex-grow pt-[68px]">
      @yield('content')
    </main>

    <footer id="tentang" class="canva-footer mt-12" style="background: rgb(8, 43, 98); color: rgb(214, 232, 250);">
      <div class="site-width grid gap-8 py-12 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1.2fr_1fr]">
        <section>
          <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10 p-1.5">
              <img src="{{ asset('assets/images/logo-bps.svg') }}" alt="Logo BPS" class="h-full w-full">
            </span>
            <div>
              <h2 class="text-sm font-extrabold text-white">PERPUSTAKAAN DIGITAL</h2>
              <p class="text-[11px] text-blue-200">BPS KABUPATEN JEMBER</p>
            </div>
          </div>
          <p class="mt-4 max-w-[260px] text-xs leading-5 text-blue-100">
            Membuka akses data dan literasi statistik terpercaya untuk mendukung riset, pendidikan, dan pembangunan daerah.
          </p>
        </section>

        <section>
          <h3 class="text-sm font-bold text-white uppercase tracking-wider">Menu Cepat</h3>
          <div class="mt-4 grid gap-2.5 text-xs text-blue-100">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <a href="{{ route('katalog.index') }}" class="hover:text-white transition font-semibold text-yellow-300">Daftar Katalog</a>
            <a href="{{ route('katalog.index') }}#kategori" class="hover:text-white transition">Kategori Publikasi</a>
            <a href="#tentang" class="hover:text-white transition">Tentang BPS</a>
            <a href="{{ route('admin.dashboard') }}" class="text-yellow-300 font-bold hover:underline">Portal Admin</a>
          </div>
        </section>

        <section>
          <h3 class="text-sm font-bold text-white uppercase tracking-wider">Layanan Statistik</h3>
          <div class="mt-4 grid gap-2.5 text-xs text-blue-100">
            <span>Pelayanan Statistik Terpadu (PST)</span>
            <span>Konsultasi Data Online</span>
            <span>Rekomendasi Statistik</span>
            <span>Perpustakaan Terbuka</span>
          </div>
        </section>

        <section>
          <h3 class="text-sm font-bold text-white uppercase tracking-wider">Kontak Kantor</h3>
          <div class="mt-4 grid gap-2 text-xs text-blue-100">
            <span class="flex items-start gap-1.5">
              <i data-lucide="map-pin" class="h-3.5 w-3.5 shrink-0 mt-0.5 text-yellow-400"></i>
              <span>Jl. Kartini No. 19, Kepatihan, Kec. Kaliwates, Kabupaten Jember, Jawa Timur 68131</span>
            </span>
            <span class="flex items-center gap-1.5 mt-1">
              <i data-lucide="phone" class="h-3.5 w-3.5 shrink-0 text-yellow-400"></i>
              <span>(0331) 487532</span>
            </span>
            <span class="flex items-center gap-1.5">
              <i data-lucide="mail" class="h-3.5 w-3.5 shrink-0 text-yellow-400"></i>
              <span>bps3509@bps.go.id</span>
            </span>
          </div>
        </section>

        <section>
          <h3 class="text-sm font-bold text-white uppercase tracking-wider">Jam Pelayanan</h3>
          <div class="mt-4 grid gap-2 text-xs text-blue-100">
            <span class="font-medium text-white">Senin – Kamis:</span>
            <span>08.00 – 15.30 WIB</span>
            <span class="font-medium text-white mt-1">Jumat:</span>
            <span>08.00 – 15.00 WIB</span>
            <span class="text-[11px] text-blue-300 mt-1">Sabtu, Minggu & Hari Libur Nasional Tutup</span>
          </div>
        </section>
      </div>

      <div class="border-t border-white/10 bg-[#061f47]">
        <div class="site-width py-4 flex flex-col sm:flex-row items-center justify-between text-[11px] text-blue-200 gap-2">
          <span>&copy; {{ date('Y') }} Badan Pusat Statistik Kabupaten Jember. Hak Cipta Dilindungi.</span>
          <span>Sistem Perpustakaan Digital & Diseminasi Informasi Statistik</span>
        </div>
      </div>
    </footer>

    <!-- Login Modal -->
    <div id="login-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#071d3a]/65 backdrop-blur-xs p-4" role="dialog" aria-modal="true" aria-labelledby="login-title">
      <div class="w-full max-w-md rounded-3xl bg-white p-6 sm:p-7 shadow-2xl transition transform">
        <div class="flex items-start justify-between gap-4">
          <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 border border-blue-100 text-[#082b62]">
              <i data-lucide="shield-check" class="h-6 w-6"></i>
            </div>
            <div>
              <h2 id="login-title" class="text-base font-extrabold text-[#082b62]">Masuk Administrator</h2>
              <p class="text-xs text-slate-500">Perpustakaan Digital BPS Jember</p>
            </div>
          </div>
          <button id="close-modal" type="button" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition" aria-label="Tutup dialog">
            <i data-lucide="x" class="h-5 w-5"></i>
          </button>
        </div>

        <!-- Login Form directly in modal -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="mt-5 space-y-3.5">
          @csrf

          <div>
            <label for="modal_email" class="block text-xs font-bold text-slate-700 mb-1">
              Email Administrator
            </label>
            <div class="relative flex items-center">
              <i data-lucide="mail" class="absolute left-3.5 h-4 w-4 text-slate-400"></i>
              <input 
                type="email" 
                name="email" 
                id="modal_email" 
                value="admin@bps.go.id"
                required 
                class="w-full rounded-xl border border-slate-200 bg-slate-50/70 py-2.5 pl-10 pr-3.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
              >
            </div>
          </div>

          <div>
            <label for="modal_password" class="block text-xs font-bold text-slate-700 mb-1">
              Kata Sandi (Password)
            </label>
            <div class="relative flex items-center">
              <i data-lucide="lock" class="absolute left-3.5 h-4 w-4 text-slate-400"></i>
              <input 
                type="password" 
                name="password" 
                id="modal_password" 
                value="password123"
                required 
                class="w-full rounded-xl border border-slate-200 bg-slate-50/70 py-2.5 pl-10 pr-3.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
              >
            </div>
          </div>

          <button 
            type="submit" 
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#082b62] py-2.5 text-xs font-extrabold text-white shadow-md hover:bg-blue-900 transition active:scale-98"
          >
            <i data-lucide="log-in" class="h-4 w-4"></i>
            <span>Masuk ke Dashboard Admin</span>
          </button>
        </form>

        <div class="mt-3.5 pt-3.5 border-t border-slate-100 flex flex-col gap-2">
          <a 
            href="{{ route('admin.quick_login') }}" 
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-amber-400 hover:bg-yellow-400 py-2 text-xs font-extrabold text-slate-900 shadow-xs transition"
          >
            <i data-lucide="zap" class="h-3.5 w-3.5"></i>
            <span>Masuk Cepat Demo (1 Klik)</span>
          </a>

          <div class="flex items-center justify-between text-[11px] pt-1 text-slate-400">
            <a href="{{ url('/admin') }}" class="text-blue-700 font-semibold hover:underline">
              Buka Halaman Penuh /admin &rarr;
            </a>
            <span>Demo: admin@bps.go.id</span>
          </div>
        </div>

        <div class="mt-3 rounded-xl bg-blue-50/60 border border-blue-100 p-2.5 text-center">
          <p class="text-[11px] text-blue-900">
            <strong>Pengunjung Umum:</strong> Seluruh buku di katalog dapat dibaca bebas tanpa perlu login.
          </p>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      if (typeof lucide !== 'undefined') {
        lucide.createIcons();
      }

      // Mobile Menu Toggle
      const mobileBtn = document.getElementById('mobile-menu-btn');
      const mobileMenu = document.getElementById('mobile-menu');
      if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
          mobileMenu.classList.toggle('hidden');
        });
      }

      // Login Modal Logic
      const modal = document.getElementById('login-modal');
      const openModal = () => {
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('modal-open');
      };
      const closeModal = () => {
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('modal-open');
      };

      const loginTrigger = document.getElementById('login-trigger');
      const mobileLoginTrigger = document.getElementById('mobile-login-trigger');
      const closeModalBtn = document.getElementById('close-modal');
      const cancelModalBtn = document.getElementById('cancel-modal');

      if (loginTrigger) loginTrigger.addEventListener('click', openModal);
      if (mobileLoginTrigger) mobileLoginTrigger.addEventListener('click', openModal);
      if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
      if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

      if (modal) {
        modal.addEventListener('click', (e) => {
          if (e.target === modal) closeModal();
        });
      }

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
          closeModal();
        }
      });
    });
  </script>
  @stack('scripts')
</body>

</html>