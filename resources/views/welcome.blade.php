<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Perpustakan Bps</title>
</head>
<body data-template-id="__page-root" style="background: rgb(248, 251, 255);">
  <div class="page-shell">
   <header class="glass-header sticky top-0 z-40">
    <div class="site-width flex h-[68px] items-center justify-between gap-4"><a href="#beranda" class="flex items-center gap-2 no-underline" aria-label="Kembali ke Beranda"> <span class="flex h-9 w-9 items-center justify-center rounded-lg text-[#0b4c95]"><i data-lucide="book-open" class="h-5 w-5"></i><img src="{{ asset('assets/images/logo-bps.svg')}}" alt="Logo Bps"></span> <span data-template-id="brand-name" class="canva-text text-[11px] font-extrabold leading-[.95] tracking-[-.04em]" style="color: rgb(8, 43, 98); font-weight: 800; font-style: normal; font-size: 11px;">PERPUSTAKAAN
BPS KABUPATEN JEMBER</span> </a>
     <nav aria-label="Navigasi utama" class="nav-scroll hidden items-center gap-6 md:flex"><a data-template-id="nav-home" class="canva-link nav-link" href="#beranda" style="color: rgb(48, 68, 97); font-weight: 600; font-style: normal; font-size: 16px;">Beranda</a> <a data-template-id="nav-catalog" class="canva-link nav-link" href="#katalog" style="color: rgb(48, 68, 97); font-weight: 600; font-style: normal; font-size: 16px;">Katalog Buku</a> <a data-template-id="nav-collection" class="canva-link nav-link" href="#koleksi" style="color: rgb(48, 68, 97); font-weight: 600; font-style: normal; font-size: 16px;">Koleksi</a> <a data-template-id="nav-about" class="canva-link nav-link" href="#tentang" style="color: rgb(48, 68, 97); font-weight: 600; font-style: normal; font-size: 16px;">Tentang Kami</a>
     </nav>
     <div class="flex items-center gap-2"><button id="header-search" type="button" class="rounded-lg p-2 text-[#183a66] hover:bg-[#edf6ff] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1565c0]" aria-label="Fokus ke pencarian katalog"> <i data-lucide="search" class="h-5 w-5"></i> </button> <button id="login-trigger" data-template-id="login-button" type="button" class="canva-button rounded-lg px-3.5 py-2 text-xs font-bold shadow-sm transition hover:brightness-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#e9ad36]" style="background: rgb(8, 43, 98); color: rgb(255, 255, 255); font-weight: 700; font-style: normal; font-size: 16px;">Masuk</button>
     </div>
    </div>
   </header>
   <main>
    <section id="beranda" class="relative py-10 md:py-14">
     <div class="site-width grid items-center gap-9 lg:grid-cols-[1.02fr_.98fr]">
      <div class="fade-up">
       <div data-template-id="hero-eyebrow" class="canva-tag mb-4 inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background: rgb(226, 241, 255); color: rgb(20, 96, 174); font-weight: 700; font-style: normal; font-size: 12px;">PERPUSTAKAAN UNTUK SEMUA</div>
       <h1 data-template-id="hero-title" class="canva-text max-w-[620px] text-4xl font-extrabold leading-[1.1] tracking-[-.045em] md:text-5xl" style="color: rgb(16, 41, 77); font-weight: 800; font-style: normal; font-size: 32px;">Temukan Dunia Baru Lewat Setiap Halaman.</h1>
       <p data-template-id="hero-description" class="canva-text mt-5 max-w-[550px] text-[15px] leading-7" style="color: rgb(93, 112, 138); font-weight: 400; font-style: normal; font-size: 15px; line-height: 1.7;">Jelajahi ribuan koleksi buku dan temukan bacaan yang sesuai untuk memperluas wawasanmu.</p>
       <div class="mt-7 flex flex-wrap gap-3"><button id="explore-button" data-template-id="explore-button-text" type="button" class="canva-button inline-flex items-center gap-2 rounded-lg px-5 py-3 text-sm font-bold shadow-md transition hover:-translate-y-0.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#e9ad36]" style="background: rgb(11, 85, 170); color: rgb(255, 255, 255); font-weight: 700; font-style: normal; font-size: 16px;">Jelajahi Koleksi</button> <button id="catalog-button" data-template-id="catalog-button-text" type="button" class="canva-button inline-flex items-center gap-2 rounded-lg border px-5 py-3 text-sm font-bold transition hover:bg-[#f2f8ff] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1565c0]" style="background: rgb(255, 255, 255); color: rgb(23, 75, 135); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Katalog</button>
       </div>
      </div>
      <div class="hero-art fade-up" style="animation-delay:.12s" aria-label="Ilustrasi pembaca sedang membaca di depan rak buku">
       <div class="dots absolute bottom-8 left-7 h-14 w-14 opacity-70"></div>
       <div class="bookshelf" aria-hidden="true"><span class="shelf"></span><span class="shelf"></span><span class="shelf"></span> <span class="book-spine" style="left:13px;height:43px;background:#e4ad35"></span><span class="book-spine" style="left:29px;height:50px;background:#55a7ce"></span><span class="book-spine" style="left:46px;height:38px;background:#e36855"></span><span class="book-spine" style="left:64px;height:52px;background:#f2d67d"></span><span class="book-spine" style="left:86px;height:45px;background:#72b58f"></span><span class="book-spine" style="left:108px;height:56px;background:#b0d3ee"></span><span class="book-spine" style="left:132px;height:41px;background:#e6a9a3"></span>
       </div>
       <div class="reader" aria-hidden="true">
        <span class="head"></span><span class="hair"></span><span class="body"></span><span class="leg one"></span><span class="leg two"></span><span class="reading-book"></span>
       </div>
       <div class="plant text-5xl" aria-hidden="true">
        ♣
       </div>
      </div>
     </div>
    </section>
    <section id="katalog" class="pb-7">
     <div class="site-width">
      <form id="catalog-form" class="search-panel grid gap-3 rounded-2xl bg-white p-4 md:grid-cols-[1fr_auto]" role="search"><label class="sr-only" for="catalog-search">Cari judul buku, penulis, atau kategori</label>
       <div class="flex items-center gap-3 rounded-xl border border-[#d8e6f4] bg-[#fbfdff] px-4"><i data-lucide="search" class="h-5 w-5 text-[#5b7190]"></i> <input id="catalog-search" data-template-id="search-input" class="canva-input h-12 w-full border-0 bg-transparent text-sm text-[#13213a] outline-none placeholder:text-[#91a1b4]" type="search" placeholder="Cari judul buku, penulis, atau kategori..." style="color: rgb(19, 33, 58); font-weight: 400; font-style: normal; font-size: 14px;">
       </div><button data-template-id="search-button" type="submit" class="canva-button rounded-xl px-7 py-3 text-sm font-bold transition hover:brightness-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#e9ad36]" style="background: rgb(11, 85, 170); color: rgb(255, 255, 255); font-weight: 700; font-style: normal; font-size: 16px;">Cari</button>
      </form>
     </div>
    </section>
    <section id="koleksi" class="py-7">
     <div class="site-width">
      <div class="mb-5 flex items-end justify-between gap-4">
       <div>
        <h2 data-template-id="categories-title" class="canva-text text-xl font-extrabold tracking-[-.03em]" style="color: rgb(19, 33, 58); font-weight: 800; font-style: normal; font-size: 24px;">Kategori Populer</h2>
        <p data-template-id="categories-description" class="canva-text mt-1 text-sm" style="color: rgb(100, 116, 139); font-weight: 400; font-style: normal; font-size: 14px;">Pilih kategori untuk menemukan bacaan favoritmu.</p>
       </div><button id="clear-filter" data-template-id="view-all-button" class="canva-button text-xs font-bold underline underline-offset-4 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1565c0]" type="button" style="color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Semua</button>
      </div>
      <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5"><button type="button" class="category-card is-active rounded-xl border border-[#e2edf7] bg-white p-4 text-center" data-category="all" aria-pressed="true"> <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-[#e6f3ff] text-[#1765b8]"><i data-lucide="layout-grid" class="h-5 w-5"></i></span> <span data-template-id="category-all" class="canva-text mt-2 block text-sm font-bold" style="color: rgb(24, 54, 84); font-weight: 700; font-style: normal; font-size: 16px;">Semua</span> <span data-template-id="category-all-count" class="canva-text mt-1 block text-[10px]" style="color: rgb(122, 141, 163); font-weight: 400; font-style: normal; font-size: 10px;">Koleksi pilihan</span> </button> <button type="button" class="category-card rounded-xl border border-[#e2edf7] bg-white p-4 text-center" data-category="Pendidikan" aria-pressed="false"> <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-[#dcefff] text-[#1765b8]"><i data-lucide="graduation-cap" class="h-5 w-5"></i></span> <span data-template-id="category-education" class="canva-text mt-2 block text-sm font-bold" style="color: rgb(24, 54, 84); font-weight: 700; font-style: normal; font-size: 16px;">Pendidikan</span> <span data-template-id="category-education-count" class="canva-text mt-1 block text-[10px]" style="color: rgb(122, 141, 163); font-weight: 400; font-style: normal; font-size: 10px;">1.264 Buku</span> </button> <button type="button" class="category-card rounded-xl border border-[#e2edf7] bg-white p-4 text-center" data-category="Teknologi" aria-pressed="false"> <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-[#d9f4f1] text-[#16857d]"><i data-lucide="laptop" class="h-5 w-5"></i></span> <span data-template-id="category-tech" class="canva-text mt-2 block text-sm font-bold" style="color: rgb(24, 54, 84); font-weight: 700; font-style: normal; font-size: 16px;">Teknologi</span> <span data-template-id="category-tech-count" class="canva-text mt-1 block text-[10px]" style="color: rgb(122, 141, 163); font-weight: 400; font-style: normal; font-size: 10px;">832 Buku</span> </button> <button type="button" class="category-card rounded-xl border border-[#e2edf7] bg-white p-4 text-center" data-category="Sains" aria-pressed="false"> <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-[#eee6ff] text-[#7454c7]"><i data-lucide="flask-conical" class="h-5 w-5"></i></span> <span data-template-id="category-science" class="canva-text mt-2 block text-sm font-bold" style="color: rgb(24, 54, 84); font-weight: 700; font-style: normal; font-size: 16px;">Sains</span> <span data-template-id="category-science-count" class="canva-text mt-1 block text-[10px]" style="color: rgb(122, 141, 163); font-weight: 400; font-style: normal; font-size: 10px;">786 Buku</span> </button> <button type="button" class="category-card rounded-xl border border-[#e2edf7] bg-white p-4 text-center" data-category="Sastra" aria-pressed="false"> <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-[#fff0cf] text-[#bd7e16]"><i data-lucide="book-heart" class="h-5 w-5"></i></span> <span data-template-id="category-literature" class="canva-text mt-2 block text-sm font-bold" style="color: rgb(24, 54, 84); font-weight: 700; font-style: normal; font-size: 16px;">Sastra</span> <span data-template-id="category-literature-count" class="canva-text mt-1 block text-[10px]" style="color: rgb(122, 141, 163); font-weight: 400; font-style: normal; font-size: 10px;">1.032 Buku</span> </button>
      </div>
     </div>
    </section>
    <!-- card buku -->
    <section class="py-7">
     <div class="site-width">
      <div class="mb-5">
       <h2 data-template-id="books-title" class="canva-text text-xl font-extrabold tracking-[-.03em]" style="color: rgb(19, 33, 58); font-weight: 800; font-style: normal; font-size: 24px;">Buku Populer</h2>
       <p id="results-message" class="mt-1 min-h-[20px] text-sm text-[#64748b]" aria-live="polite"></p>
      </div>
      <div id="book-grid" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Laut Bercerita" data-author="Leila S. Chudori" data-category="Sastra">
        <div class="cover bg-[#2f719a] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku1.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-1-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Sastra</span>
         <h3 data-template-id="book-1-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Laut Bercerita</h3>
         <p data-template-id="book-1-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">Leila S. Chudori</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-1-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.8 (320)</span>
         </div><button data-template-id="book-1-detail" data-book="Laut Bercerita" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Atomic Habits" data-author="James Clear" data-category="Pendidikan">
        <div class="cover bg-[#f1ead9] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku2.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-2-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Pendidikan</span>
         <h3 data-template-id="book-2-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Atomic Habits</h3>
         <p data-template-id="book-2-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">James Clear</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-2-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.9 (416)</span>
         </div><button data-template-id="book-2-detail" data-book="Atomic Habits" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Sapiens" data-author="Yuval Noah Harari" data-category="Sejarah">
        <div class="cover bg-[#1c2933] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku3.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-3-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Sejarah</span>
         <h3 data-template-id="book-3-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Sapiens</h3>
         <p data-template-id="book-3-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">Yuval Noah Harari</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-3-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.7 (299)</span>
         </div><button data-template-id="book-3-detail" data-book="Sapiens" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Laskar Pelangi" data-author="Andrea Hirata" data-category="Sastra">
        <div class="cover bg-[#e9c56b] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku4.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-4-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Sastra</span>
         <h3 data-template-id="book-4-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Laskar Pelangi</h3>
         <p data-template-id="book-4-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">Andrea Hirata</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <!-- <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-4-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.8 (281)</span> -->
         </div><button data-template-id="book-4-detail" data-book="Laskar Pelangi" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Bumi" data-author="Tere Liye" data-category="Sains">
        <div class="cover bg-[#246d66] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku5.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-5-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Sains</span>
         <h3 data-template-id="book-5-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Bumi</h3>
         <p data-template-id="book-5-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">Tere Liye</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-5-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.8 (403)</span>
         </div><button data-template-id="book-5-detail" data-book="Bumi" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
      </div>
      <p id="empty-state" data-template-id="empty-state" class="canva-text hidden rounded-xl border border-dashed border-[#cbdceb] bg-white p-8 text-center text-sm" style="color: rgb(100, 116, 139); font-weight: 400; font-style: normal; font-size: 14px;">Belum ada buku yang sesuai. Coba gunakan kata kunci atau kategori lain.</p>
     </div>
    </section>

  <!-- card buku -->
      <section class="py-7">
     <div class="site-width">
      <div class="mb-5">
       <h2 data-template-id="books-title" class="canva-text text-xl font-extrabold tracking-[-.03em]" style="color: rgb(19, 33, 58); font-weight: 800; font-style: normal; font-size: 24px;">Buku Populer</h2>
       <p id="results-message" class="mt-1 min-h-[20px] text-sm text-[#64748b]" aria-live="polite"></p>
      </div>
      <div id="book-grid" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Laut Bercerita" data-author="Leila S. Chudori" data-category="Sastra">
        <div class="cover aspect-[3/4] w-full">
          <img src="{{ asset('assets/images/cover-buku.jpeg')}}" alt="cover buku" class="w-full h-full object-cover">
              </div>
        <div class="p-4"><span data-template-id="book-1-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Sastra</span>
         <h3 data-template-id="book-1-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Laut Bercerita</h3>
         <p data-template-id="book-1-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">Leila S. Chudori</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-1-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.8 (320)</span>
         </div><button data-template-id="book-1-detail" data-book="Laut Bercerita" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Atomic Habits" data-author="James Clear" data-category="Pendidikan">
        <div class="cover bg-[#f1ead9] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku5.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-2-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Pendidikan</span>
         <h3 data-template-id="book-2-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Atomic Habits</h3>
         <p data-template-id="book-2-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">James Clear</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-2-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.9 (416)</span>
         </div><button data-template-id="book-2-detail" data-book="Atomic Habits" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Sapiens" data-author="Yuval Noah Harari" data-category="Sejarah">
        <div class="cover bg-[#1c2933] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku1.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-3-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Sejarah</span>
         <h3 data-template-id="book-3-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Sapiens</h3>
         <p data-template-id="book-3-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">Yuval Noah Harari</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-3-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.7 (299)</span>
         </div><button data-template-id="book-3-detail" data-book="Sapiens" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Laskar Pelangi" data-author="Andrea Hirata" data-category="Sastra">
        <div class="cover bg-[#e9c56b] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku2.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-4-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Sastra</span>
         <h3 data-template-id="book-4-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Laskar Pelangi</h3>
         <p data-template-id="book-4-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">Andrea Hirata</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-4-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.8 (281)</span>
         </div><button data-template-id="book-4-detail" data-book="Laskar Pelangi" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
       <article class="book-card overflow-hidden rounded-md border border-[#e0ebf5] bg-white" data-title="Bumi" data-author="Tere Liye" data-category="Sains">
        <div class="cover bg-[#246d66] aspect-[3/4] w-full">
         <img src="{{ asset('assets/images/cover-buku3.jpg')}}" alt="cover buku" class="w-full h-full object-cover">
        </div>
        <div class="p-4"><span data-template-id="book-5-category" class="canva-tag text-[10px] font-bold uppercase tracking-wider" style="color: rgb(36, 116, 109); font-weight: 700; font-style: normal; font-size: 16px;">Sains</span>
         <h3 data-template-id="book-5-title" class="canva-text mt-2 text-[15px] font-extrabold leading-tight" style="color: rgb(23, 42, 67); font-weight: 800; font-style: normal; font-size: 19px;">Bumi</h3>
         <p data-template-id="book-5-author" class="canva-text mt-1 text-xs" style="color: rgb(112, 129, 152); font-weight: 400; font-style: normal; font-size: 12px;">Tere Liye</p>
         <div class="mt-3 flex items-center gap-1 text-[#df9d1f]">
          <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i><span data-template-id="book-5-rating" class="canva-text text-xs font-bold" style="color: rgb(84, 106, 132); font-weight: 700; font-style: normal; font-size: 12px;">4.8 (403)</span>
         </div><button data-template-id="book-5-detail" data-book="Bumi" type="button" class="canva-button mt-4 w-full rounded-lg border px-3 py-2 text-xs font-bold" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Lihat Detail</button>
        </div>
       </article>
      </div>
      <p id="empty-state" data-template-id="empty-state" class="canva-text hidden rounded-xl border border-dashed border-[#cbdceb] bg-white p-8 text-center text-sm" style="color: rgb(100, 116, 139); font-weight: 400; font-style: normal; font-size: 14px;">Belum ada buku yang sesuai. Coba gunakan kata kunci atau kategori lain.</p>
     </div>
    <section class="py-8">
     <div class="site-width">
      <div data-template-id="cta-banner" class="canva-banner relative overflow-hidden rounded-2xl p-7 md:flex md:items-center md:justify-between md:p-9" style="background: linear-gradient(115deg, rgb(8, 43, 98), rgb(18, 105, 191));">
       <div class="relative z-10">
        <h2 data-template-id="cta-title" class="canva-text text-2xl font-extrabold tracking-[-.035em]" style="color: rgb(255, 255, 255); font-weight: 800; font-style: normal; font-size: 24px;">Belum menemukan buku yang kamu cari?</h2>
        <p data-template-id="cta-description" class="canva-text mt-2 max-w-[590px] text-sm leading-6" style="color: rgb(216, 236, 255); font-weight: 400; font-style: normal; font-size: 14px;">Cari di katalog lengkap kami dan temukan banyak koleksi menarik lainnya.</p>
       </div><button id="cta-catalog-button" data-template-id="cta-button" type="button" class="canva-button relative z-10 mt-5 rounded-lg px-5 py-3 text-sm font-bold shadow-md transition hover:-translate-y-0.5 md:mt-0" style="background: rgb(255, 255, 255); color: rgb(11, 85, 170); font-weight: 700; font-style: normal; font-size: 16px;">Cari di Katalog Lengkap</button> <i data-lucide="book-open" class="absolute -bottom-8 right-5 h-40 w-40 rotate-[-13deg] text-white opacity-15"></i>
      </div>
     </div>
    </section>
   </main>
   <footer id="tentang" data-template-id="footer-section" class="canva-footer mt-4" style="background: rgb(8, 43, 98); color: rgb(214, 232, 250);">
    <div class="site-width grid gap-8 py-10 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1.2fr_1fr]">
     <section>
      <div class="flex items-center gap-2"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/15"><i data-lucide="book-open" class="h-4 w-4"></i></span>
       <h2 data-template-id="footer-brand" class="canva-text text-xs font-extrabold" style="color: rgb(255, 255, 255); font-weight: 800; font-style: normal; font-size: 24px;">PERPUSTAKAAN DIGITAL</h2>
      </div>
      <p data-template-id="footer-description" class="canva-text mt-4 max-w-[220px] text-xs leading-5" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Membuka akses pengetahuan untuk belajar, tumbuh, dan menginspirasi.</p>
     </section>
     <section>
      <h3 data-template-id="footer-menu-title" class="canva-text text-sm font-bold" style="color: rgb(255, 255, 255); font-weight: 700; font-style: normal; font-size: 19px;">Menu</h3>
      <div class="mt-3 grid gap-2 text-xs">
       <a data-template-id="footer-menu-home" class="canva-link" href="#beranda" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Beranda</a><a data-template-id="footer-menu-catalog" class="canva-link" href="#katalog" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Katalog Buku</a><a data-template-id="footer-menu-collection" class="canva-link" href="#koleksi" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Koleksi</a>
      </div>
     </section>
     <section>
      <h3 data-template-id="footer-info-title" class="canva-text text-sm font-bold" style="color: rgb(255, 255, 255); font-weight: 700; font-style: normal; font-size: 19px;">Informasi</h3>
      <div class="mt-3 grid gap-2 text-xs">
       <span data-template-id="footer-info-1" class="canva-text" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Cara Peminjaman</span><span data-template-id="footer-info-2" class="canva-text" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Ketentuan Layanan</span><span data-template-id="footer-info-3" class="canva-text" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Bantuan</span>
      </div>
     </section>
     <section>
      <h3 data-template-id="footer-contact-title" class="canva-text text-sm font-bold" style="color: rgb(255, 255, 255); font-weight: 700; font-style: normal; font-size: 19px;">Kontak Kami</h3>
      <div class="mt-3 grid gap-2 text-xs">
       <span data-template-id="footer-address" class="canva-text" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Jl. Pengetahuan No. 18, Surabaya</span><span data-template-id="footer-phone" class="canva-text" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">(031) 555-0198</span><span data-template-id="footer-email" class="canva-text" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">info@perpusdigital.id</span>
      </div>
     </section>
     <section>
      <h3 data-template-id="footer-hours-title" class="canva-text text-sm font-bold" style="color: rgb(255, 255, 255); font-weight: 700; font-style: normal; font-size: 19px;">Jam Layanan</h3>
      <div class="mt-3 grid gap-2 text-xs">
       <span data-template-id="footer-hours-weekday" class="canva-text" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Senin–Jumat: 08.00–20.00 WIB</span><span data-template-id="footer-hours-weekend" class="canva-text" style="color: rgb(189, 215, 238); font-weight: 400; font-style: normal; font-size: 12px;">Sabtu: 09.00–16.00 WIB</span>
      </div>
     </section>
    </div>
    <div class="border-t border-white/15">
     <div data-template-id="copyright" class="canva-text site-width py-4 text-center text-[11px]" style="color: rgb(158, 194, 225); font-weight: 400; font-style: normal; font-size: 11px;">© 2026 Perpustakaan Digital. All rights reserved.</div>
    </div>
   </footer>
  </div>
  <div id="login-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#071d3a]/55 p-4" role="dialog" aria-modal="true" aria-labelledby="login-title">
   <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
    <div class="flex items-start justify-between gap-4">
     <div>
      <h2 id="login-title" data-template-id="modal-title" class="canva-text text-xl font-extrabold" style="color: rgb(19, 33, 58); font-weight: 800; font-style: normal; font-size: 24px;">Masuk ke Perpustakaan</h2>
      <p data-template-id="modal-description" class="canva-text mt-1 text-sm" style="color: rgb(100, 116, 139); font-weight: 400; font-style: normal; font-size: 14px;">Akses anggota akan segera tersedia.</p>
     </div><button id="close-modal" type="button" class="rounded-lg p-2 text-[#46617f] hover:bg-[#edf6ff]" aria-label="Tutup dialog"><i data-lucide="x" class="h-5 w-5"></i></button>
    </div>
    <div class="mt-6 rounded-xl bg-[#f1f7fd] p-4">
     <p data-template-id="modal-note" class="canva-text text-sm leading-6" style="color: rgb(49, 82, 113); font-weight: 400; font-style: normal; font-size: 14px; line-height: 1.6;">Halaman ini adalah katalog terbuka. Kamu tetap dapat menjelajahi koleksi dan mencari buku tanpa masuk.</p>
    </div><button id="cancel-modal" data-template-id="modal-close-button" type="button" class="canva-button mt-6 w-full rounded-lg px-4 py-3 text-sm font-bold" style="background: rgb(11, 85, 170); color: rgb(255, 255, 255); font-weight: 700; font-style: normal; font-size: 16px;">Kembali ke Katalog</button>
   </div>
  </div>
  <script src="/_sdk/0aac212797dcb9a6.editing_sdk.js" integrity="sha512-U1Z5TGB/MTX0fFSADhP7rVM3+UzJJjKTapiY1vm1cxcbcyWo4eBuCJNJO6zARJ5kHopP9UvWNtPszOqzRc1ICA=="></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      lucide.createIcons();

      const searchInput = document.getElementById('catalog-search');
      const bookCards = [...document.querySelectorAll('.book-card')];
      const categoryButtons = [...document.querySelectorAll('.category-card')];
      const results = document.getElementById('results-message');
      const emptyState = document.getElementById('empty-state');
      let activeCategory = 'all';

      function filterBooks() {
        const query = searchInput.value.trim().toLowerCase();
        let visible = 0;
        bookCards.forEach(card => {
          const searchable = (card.dataset.title + ' ' + card.dataset.author + ' ' + card.dataset.category).toLowerCase();
          const categoryMatch = activeCategory === 'all' || card.dataset.category === activeCategory;
          const match = categoryMatch && searchable.includes(query);
          card.classList.toggle('hidden', !match);
          if (match) visible++;
        });
        emptyState.classList.toggle('hidden', visible !== 0);
        results.textContent = query || activeCategory !== 'all'
          ? `${visible} buku ditemukan${activeCategory !== 'all' ? ' dalam kategori ' + activeCategory : ''}.`
          : '';
      }

      document.getElementById('catalog-form').addEventListener('submit', event => { event.preventDefault(); filterBooks(); });
      searchInput.addEventListener('input', filterBooks);
      document.getElementById('header-search').addEventListener('click', () => {
        document.getElementById('katalog').scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => searchInput.focus(), 450);
      });

      categoryButtons.forEach(button => button.addEventListener('click', () => {
        activeCategory = button.dataset.category;
        categoryButtons.forEach(item => {
          const selected = item === button;
          item.classList.toggle('is-active', selected);
          item.setAttribute('aria-pressed', String(selected));
        });
        filterBooks();
        document.querySelector('.book-card:not(.hidden), #empty-state').scrollIntoView({ behavior: 'smooth', block: 'center' });
      }));

      document.getElementById('clear-filter').addEventListener('click', () => {
        activeCategory = 'all';
        searchInput.value = '';
        categoryButtons.forEach((item, index) => { item.classList.toggle('is-active', index === 0); item.setAttribute('aria-pressed', String(index === 0)); });
        filterBooks();
      });

      ['explore-button', 'catalog-button', 'cta-catalog-button'].forEach(id => document.getElementById(id).addEventListener('click', () => {
        document.getElementById('koleksi').scrollIntoView({ behavior: 'smooth', block: 'start' });
      }));

      document.querySelectorAll('[data-book]').forEach(button => button.addEventListener('click', () => {
        results.textContent = `“${button.dataset.book}” dipilih. Gunakan pencarian untuk menemukan buku lain yang relevan.`;
        results.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }));

      const modal = document.getElementById('login-modal');
      const openModal = () => { modal.classList.remove('hidden'); modal.classList.add('flex'); document.body.classList.add('modal-open'); document.getElementById('close-modal').focus(); };
      const closeModal = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.classList.remove('modal-open'); document.getElementById('login-trigger').focus(); };
      document.getElementById('login-trigger').addEventListener('click', openModal);
      document.getElementById('close-modal').addEventListener('click', closeModal);
      document.getElementById('cancel-modal').addEventListener('click', closeModal);
      modal.addEventListener('click', event => { if (event.target === modal) closeModal(); });
      document.addEventListener('keydown', event => { if (event.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });
    });
  </script>
 
</body></html>