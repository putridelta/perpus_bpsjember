<header class="glass-header fixed w-full top-0 z-40">
  <div class="site-width flex h-[68px] items-center justify-between gap-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="flex items-center gap-2.5 no-underline" aria-label="Kembali ke Beranda">
      <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 border border-blue-100 text-[#0b4c95] shadow-xs">
        <img src="{{ asset('assets/images/logo-bps.svg') }}" alt="Logo BPS" class="h-6 w-6">
      </span>
      <div class="flex flex-col">
        <span class="text-[12px] font-black leading-tight tracking-tight text-[#082b62]">
          PERPUSTAKAAN DIGITAL
        </span>
        <span class="text-[10px] font-semibold text-blue-700 tracking-wider">
          BPS KABUPATEN JEMBER
        </span>
      </div>
    </a>

    <!-- Desktop Navigation -->
    <nav aria-label="Navigasi utama" class="nav-scroll hidden items-center gap-7 md:flex">
      <a class="nav-link text-sm font-semibold transition {{ request()->routeIs('home') || request()->routeIs('landing') ? 'text-[#1565c0] font-bold border-b-2 border-[#1565c0] pb-1' : 'text-[#304461] hover:text-[#1565c0]' }}" href="{{ route('home') }}">
        Beranda
      </a> 
      <a class="nav-link text-sm font-semibold transition {{ request()->routeIs('katalog.*') ? 'text-[#1565c0] font-bold border-b-2 border-[#1565c0] pb-1' : 'text-[#304461] hover:text-[#1565c0]' }}" href="{{ route('katalog.index') }}">
        Daftar Katalog
      </a> 
      <a class="nav-link text-sm font-semibold transition text-[#304461] hover:text-[#1565c0]" href="{{ route('katalog.index') }}">
        Koleksi Buku
      </a> 
      <a class="nav-link text-sm font-semibold transition text-[#304461] hover:text-[#1565c0]" href="{{ route('home') }}#tentang">
        Tentang Kami
      </a>
    </nav>

    <!-- Header Actions -->
    <div class="flex items-center gap-2.5">
      <a href="{{ route('katalog.index') }}" class="rounded-lg p-2 text-[#183a66] hover:bg-[#edf6ff] transition" title="Cari di Katalog" aria-label="Buka Pencarian Katalog">
        <i data-lucide="search" class="h-5 w-5"></i>
      </a>

      <button id="login-trigger" type="button" class="hidden sm:inline-flex items-center gap-1.5 rounded-lg px-4 py-2 text-xs font-bold text-white shadow-xs transition hover:brightness-110 active:scale-95" style="background: rgb(8, 43, 98);">
        <i data-lucide="user" class="h-3.5 w-3.5"></i>
        <span>Masuk</span>
      </button>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-btn" type="button" class="md:hidden rounded-lg p-2 text-[#183a66] hover:bg-[#edf6ff] transition" aria-label="Buka Menu Mobile">
        <i data-lucide="menu" class="h-6 w-6"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Navigation Dropdown -->
  <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white/95 backdrop-blur-md px-6 py-4 shadow-lg">
    <div class="flex flex-col gap-3 text-sm">
      <a class="py-2 font-medium {{ request()->routeIs('home') ? 'text-[#1565c0] font-bold' : 'text-slate-700' }}" href="{{ route('home') }}">
        Beranda
      </a>
      <a class="py-2 font-medium {{ request()->routeIs('katalog.*') ? 'text-[#1565c0] font-bold' : 'text-slate-700' }}" href="{{ route('katalog.index') }}">
        Daftar Katalog
      </a>
      <a class="py-2 font-medium text-slate-700" href="{{ route('katalog.index') }}">
        Koleksi Buku
      </a>
      <a class="py-2 font-medium text-slate-700" href="{{ route('home') }}#tentang">
        Tentang Kami
      </a>
      <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
        <button id="mobile-login-trigger" type="button" class="w-full rounded-lg px-4 py-2.5 text-xs font-bold text-white text-center shadow-xs" style="background: rgb(8, 43, 98);">
          Masuk Anggota
        </button>
      </div>
    </div>
  </div>
</header>