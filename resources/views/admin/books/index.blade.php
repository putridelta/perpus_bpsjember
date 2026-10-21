@extends('admin.layouts.app')

@section('title', 'Manajemen Buku')
@section('header_title', 'Manajemen Koleksi Buku & Publikasi')
@section('header_subtitle', 'Kelola daftar buku statistik resmi, terbitan kecamatan, indikator ekonomi, dan dokumen e-book.')

@section('content')
<div class="space-y-6">

  <!-- Header Banner & Action Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <div>
      <div class="flex items-center gap-2">
        <h2 class="text-lg font-black text-[#082b62]">Daftar Seluruh Buku</h2>
        <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-700">
          {{ number_format($totalBooks) }} Judul
        </span>
      </div>
      <p class="text-xs text-slate-500 mt-0.5">
        {{ $publishedCount }} Publikasi Published &bull; {{ $draftCount }} Draft
      </p>
    </div>

    <a 
      href="{{ route('admin.books.create') }}" 
      class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#082b62] px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-[#0e3c82] transition transform hover:-translate-y-0.5"
    >
      <i data-lucide="plus" class="h-4 w-4 text-yellow-400"></i>
      <span>Tambah Buku Baru</span>
    </a>
  </div>

  <!-- Search & Filter Card -->
  <div class="rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <form action="{{ route('admin.books.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
      
      <!-- Search Input -->
      <div class="lg:col-span-5 relative flex items-center">
        <i data-lucide="search" class="absolute left-3.5 h-4 w-4 text-slate-400"></i>
        <input 
          type="search" 
          name="search" 
          value="{{ $search }}"
          placeholder="Cari judul, penulis, ISBN, atau sinopsis..." 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <!-- Category Filter -->
      <div class="lg:col-span-3">
        <select 
          name="category_id" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Semua Kategori</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Status Filter -->
      <div class="lg:col-span-2">
        <select 
          name="status" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Semua Status</option>
          <option value="published" {{ $selectedStatus === 'published' ? 'selected' : '' }}>Published</option>
          <option value="draft" {{ $selectedStatus === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
      </div>

      <!-- Year Filter & Actions -->
      <div class="lg:col-span-2 flex items-center gap-2">
        <select 
          name="year" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Tahun</option>
          @foreach($years as $yr)
            <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
          @endforeach
        </select>

        <button 
          type="submit" 
          class="rounded-xl bg-[#082b62] p-2.5 text-white hover:bg-blue-900 transition shrink-0" 
          title="Terapkan Filter"
        >
          <i data-lucide="filter" class="h-4 w-4"></i>
        </button>

        @if(!empty($search) || ($selectedCategory && $selectedCategory !== 'all') || ($selectedStatus && $selectedStatus !== 'all') || ($selectedYear && $selectedYear !== 'all'))
          <a 
            href="{{ route('admin.books.index') }}" 
            class="rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-600 hover:bg-slate-100 transition shrink-0"
            title="Reset Filter"
          >
            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
          </a>
        @endif
      </div>

    </form>
  </div>

  <!-- Books Table -->
  <div class="overflow-hidden rounded-2xl bg-white border border-slate-200/90 shadow-xs">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-700 border-b border-slate-200">
          <tr>
            <th class="py-3.5 px-4 w-12 text-center">No</th>
            <th class="py-3.5 px-4">Buku & Sampul</th>
            <th class="py-3.5 px-4">Kategori</th>
            <th class="py-3.5 px-4">Penulis & Penerbit</th>
            <th class="py-3.5 px-4 text-center">Tahun</th>
            <th class="py-3.5 px-4 text-center">Status</th>
            <th class="py-3.5 px-4 text-center">Dibaca</th>
            <th class="py-3.5 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-medium">
          @forelse($books as $index => $book)
            <tr class="hover:bg-blue-50/20 transition">
              <!-- Number -->
              <td class="py-3.5 px-4 text-center text-slate-400 font-semibold">
                {{ $books->firstItem() + $index }}
              </td>

              <!-- Cover & Title -->
              <td class="py-3.5 px-4">
                <div class="flex items-start gap-3 min-w-[240px] max-w-sm">
                  <img 
                    src="{{ $book->cover_url }}" 
                    alt="{{ $book->name }}" 
                    class="h-14 w-10 shrink-0 rounded-md object-cover shadow-xs border border-slate-200"
                    onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
                  >
                  <div class="min-w-0">
                    <a href="{{ route('admin.books.show', $book) }}" class="font-extrabold text-slate-900 hover:text-blue-700 transition leading-snug line-clamp-2">
                      {{ $book->name }}
                    </a>
                    <span class="text-[10px] text-slate-400 font-mono mt-0.5 block">
                      ISBN: {{ $book->isbn ?: '-' }}
                    </span>
                  </div>
                </div>
              </td>

              <!-- Category -->
              <td class="py-3.5 px-4 whitespace-nowrap">
                <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-blue-700 border border-blue-100">
                  {{ $book->category?->name ?? 'Statistik' }}
                </span>
              </td>

              <!-- Author & Publisher -->
              <td class="py-3.5 px-4 min-w-[160px]">
                <p class="text-slate-800 font-semibold truncate">{{ $book->author ?: 'BPS Kabupaten Jember' }}</p>
                <p class="text-[11px] text-slate-400 truncate">{{ $book->publisher ?: 'BPS' }}</p>
              </td>

              <!-- Year -->
              <td class="py-3.5 px-4 text-center font-bold text-slate-700 whitespace-nowrap">
                {{ $book->published_year }}
              </td>

              <!-- Status -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                @if($book->status === 'published')
                  <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 border border-emerald-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Published
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-600 border border-slate-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                    Draft
                  </span>
                @endif
              </td>

              <!-- Reads Count -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <span class="inline-flex items-center gap-1 font-bold text-slate-800">
                  <i data-lucide="eye" class="h-3.5 w-3.5 text-slate-400"></i>
                  {{ number_format($book->views_count) }}
                </span>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div class="inline-flex items-center gap-1">
                  <!-- Detail Button -->
                  <a 
                    href="{{ route('admin.books.show', $book) }}"
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-blue-50 hover:text-blue-700 transition"
                    title="Lihat Detail Buku"
                  >
                    <i data-lucide="info" class="h-4 w-4"></i>
                  </a>

                  <!-- Read Button -->
                  <a 
                    href="{{ route('katalog.baca', $book) }}" 
                    target="_blank"
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 transition"
                    title="Buka Pembaca E-Book"
                  >
                    <i data-lucide="book-open" class="h-4 w-4"></i>
                  </a>

                  <!-- Edit Button -->
                  <a 
                    href="{{ route('admin.books.edit', $book) }}" 
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-amber-50 hover:text-amber-700 transition"
                    title="Edit Buku"
                  >
                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                  </a>

                  <!-- Delete Button -->
                  <button 
                    type="button" 
                    onclick="openDeleteModal('{{ route('admin.books.destroy', $book) }}', '{{ addslashes($book->name) }}')"
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-rose-50 hover:text-rose-700 transition"
                    title="Hapus Buku"
                  >
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="py-12 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center">
                  <i data-lucide="book-x" class="h-10 w-10 text-slate-300 mb-2"></i>
                  <p class="font-bold text-slate-600">Tidak ada buku yang ditemukan</p>
                  <p class="text-xs text-slate-400 mt-0.5">Coba gunakan kata kunci lain atau ubah filter pencarian.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
      <div class="border-t border-slate-100 p-4">
        {{ $books->links() }}
      </div>
    @endif
  </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
  <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl transition transform">
    <div class="flex items-center gap-3 text-rose-600 mb-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50">
        <i data-lucide="alert-triangle" class="h-5 w-5"></i>
      </span>
      <h3 class="text-base font-extrabold text-slate-900">Konfirmasi Hapus Buku</h3>
    </div>

    <p class="text-xs text-slate-600 leading-relaxed">
      Apakah Anda yakin ingin menghapus buku berikut? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
    </p>

    <div class="my-4 rounded-xl bg-slate-50 border border-slate-200 p-3">
      <p id="deleteBookTitle" class="text-xs font-bold text-slate-800 line-clamp-2"></p>
    </div>

    <form id="deleteForm" method="POST" action="">
      @csrf
      @method('DELETE')
      <div class="flex items-center justify-end gap-2.5">
        <button 
          type="button" 
          onclick="closeDeleteModal()" 
          class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
        >
          Batal
        </button>
        <button 
          type="submit" 
          class="inline-flex items-center gap-1.5 rounded-xl bg-rose-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-rose-700 transition"
        >
          <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
          <span>Ya, Hapus Buku</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function openDeleteModal(deleteUrl, bookTitle) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const titleEl = document.getElementById('deleteBookTitle');

    form.action = deleteUrl;
    titleEl.textContent = bookTitle;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
@endpush
