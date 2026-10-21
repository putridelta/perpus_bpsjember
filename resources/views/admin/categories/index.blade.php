@extends('admin.layouts.app')

@section('title', 'Kategori Buku')
@section('header_title', 'Klasifikasi Kategori Publikasi')
@section('header_subtitle', 'Kelola rumpun topik dan kategori statistik untuk pengelompokan buku dan dokumen daerah.')

@section('content')
<div class="space-y-6">

  <!-- Header Banner & Action Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <div>
      <div class="flex items-center gap-2">
        <h2 class="text-lg font-black text-[#082b62]">Daftar Kategori Publikasi</h2>
        <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-700">
          {{ number_format($totalCategories) }} Kategori
        </span>
      </div>
      <p class="text-xs text-slate-500 mt-0.5">
        Setiap kategori digunakan untuk mengelompokkan buku publikasi statistik pada katalog.
      </p>
    </div>

    <button 
      type="button" 
      onclick="openAddCategoryModal()"
      class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#082b62] px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-[#0e3c82] transition transform hover:-translate-y-0.5"
    >
      <i data-lucide="plus" class="h-4 w-4 text-yellow-400"></i>
      <span>Tambah Kategori Baru</span>
    </button>
  </div>

  <!-- Search Input -->
  <div class="rounded-2xl bg-white p-4 border border-slate-200/90 shadow-xs">
    <form action="{{ route('admin.categories.index') }}" method="GET" class="flex items-center gap-2">
      <div class="relative flex-1">
        <i data-lucide="search" class="absolute left-3.5 top-3 h-4 w-4 text-slate-400"></i>
        <input 
          type="search" 
          name="search" 
          value="{{ $search }}"
          placeholder="Cari nama atau deskripsi kategori..." 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <button 
        type="submit" 
        class="rounded-xl bg-[#082b62] px-4 py-2.5 text-xs font-bold text-white hover:bg-blue-900 transition"
      >
        Cari
      </button>

      @if(!empty($search))
        <a 
          href="{{ route('admin.categories.index') }}" 
          class="rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-600 hover:bg-slate-100 transition"
          title="Reset"
        >
          <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
        </a>
      @endif
    </form>
  </div>

  <!-- Categories Table -->
  <div class="overflow-hidden rounded-2xl bg-white border border-slate-200/90 shadow-xs">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-700 border-b border-slate-200">
          <tr>
            <th class="py-3.5 px-4 w-12 text-center">No</th>
            <th class="py-3.5 px-4">Ikon & Nama Kategori</th>
            <th class="py-3.5 px-4">Slug URL</th>
            <th class="py-3.5 px-4">Deskripsi</th>
            <th class="py-3.5 px-4 text-center">Jumlah Buku</th>
            <th class="py-3.5 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-medium">
          @forelse($categories as $index => $cat)
            <tr class="hover:bg-blue-50/20 transition">
              <!-- Number -->
              <td class="py-3.5 px-4 text-center text-slate-400 font-semibold">
                {{ $index + 1 }}
              </td>

              <!-- Icon & Name -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-3">
                  <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700 border border-blue-100">
                    <i data-lucide="{{ $cat->icon ?: 'book-open' }}" class="h-5 w-5"></i>
                  </span>
                  <div>
                    <span class="font-extrabold text-slate-900 text-sm block">
                      {{ $cat->name }}
                    </span>
                    <span class="text-[10px] text-slate-400">ID: #{{ $cat->id }}</span>
                  </div>
                </div>
              </td>

              <!-- Slug -->
              <td class="py-3.5 px-4">
                <code class="rounded bg-slate-100 px-2 py-1 text-[11px] text-slate-700 font-mono">
                  {{ $cat->slug }}
                </code>
              </td>

              <!-- Description -->
              <td class="py-3.5 px-4 max-w-xs">
                <p class="text-slate-600 truncate">
                  {{ $cat->description ?: '-' }}
                </p>
              </td>

              <!-- Book Count Badge -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <a 
                  href="{{ route('admin.books.index', ['category_id' => $cat->id]) }}" 
                  class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 hover:bg-blue-100 transition border border-blue-100"
                  title="Klik untuk melihat buku di kategori ini"
                >
                  <i data-lucide="book" class="h-3.5 w-3.5"></i>
                  <span>{{ $cat->books_count }} Koleksi</span>
                </a>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div class="inline-flex items-center gap-1">
                  <!-- Edit Category Button -->
                  <button 
                    type="button" 
                    onclick="openEditCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description ?? '') }}', '{{ $cat->icon }}')"
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-amber-50 hover:text-amber-700 transition"
                    title="Edit Kategori"
                  >
                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                  </button>

                  <!-- Delete Category Button -->
                  <button 
                    type="button" 
                    onclick="openDeleteCategoryModal('{{ route('admin.categories.destroy', $cat) }}', '{{ addslashes($cat->name) }}', {{ $cat->books_count }})"
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-rose-50 hover:text-rose-700 transition"
                    title="Hapus Kategori"
                  >
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center">
                  <i data-lucide="tags" class="h-10 w-10 text-slate-300 mb-2"></i>
                  <p class="font-bold text-slate-600">Tidak ada kategori ditemukan</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Modal: Tambah Kategori -->
<div id="addCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
  <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl transition transform">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
      <h3 class="text-base font-extrabold text-[#082b62]">Tambah Kategori Baru</h3>
      <button type="button" onclick="closeAddCategoryModal()" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100">
        <i data-lucide="x" class="h-5 w-5"></i>
      </button>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label for="cat_name" class="block text-xs font-bold text-slate-700 mb-1.5">
          Nama Kategori <span class="text-rose-500">*</span>
        </label>
        <input 
          type="text" 
          name="name" 
          id="cat_name" 
          required 
          placeholder="Contoh: Industri & Perdagangan"
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <div>
        <label for="cat_icon" class="block text-xs font-bold text-slate-700 mb-1.5">
          Ikon Lucide (Opsional)
        </label>
        <select 
          name="icon" 
          id="cat_icon" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="book-open">Buku (book-open)</option>
          <option value="map-pin">Kewilayahan (map-pin)</option>
          <option value="trending-up">Ekonomi (trending-up)</option>
          <option value="users">Kependudukan (users)</option>
          <option value="sprout">Pertanian (sprout)</option>
          <option value="briefcase">Bisnis & Industri (briefcase)</option>
          <option value="compass">Pariwisata (compass)</option>
          <option value="activity">Kesehatan (activity)</option>
          <option value="graduation-cap">Pendidikan (graduation-cap)</option>
        </select>
      </div>

      <div>
        <label for="cat_desc" class="block text-xs font-bold text-slate-700 mb-1.5">
          Deskripsi Kategori (Opsional)
        </label>
        <textarea 
          name="description" 
          id="cat_desc" 
          rows="3" 
          placeholder="Jelaskan cakupan topik dari kategori ini..."
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        ></textarea>
      </div>

      <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button 
          type="button" 
          onclick="closeAddCategoryModal()" 
          class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
        >
          Batal
        </button>
        <button 
          type="submit" 
          class="inline-flex items-center gap-1.5 rounded-xl bg-[#082b62] px-5 py-2 text-xs font-bold text-white shadow-xs hover:bg-blue-900"
        >
          <i data-lucide="plus" class="h-3.5 w-3.5 text-yellow-400"></i>
          <span>Simpan Kategori</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Edit Kategori -->
<div id="editCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
  <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl transition transform">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
      <h3 class="text-base font-extrabold text-[#082b62]">Edit Kategori</h3>
      <button type="button" onclick="closeEditCategoryModal()" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100">
        <i data-lucide="x" class="h-5 w-5"></i>
      </button>
    </div>

    <form id="editCategoryForm" method="POST" action="" class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label for="edit_cat_name" class="block text-xs font-bold text-slate-700 mb-1.5">
          Nama Kategori <span class="text-rose-500">*</span>
        </label>
        <input 
          type="text" 
          name="name" 
          id="edit_cat_name" 
          required 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <div>
        <label for="edit_cat_icon" class="block text-xs font-bold text-slate-700 mb-1.5">
          Ikon Lucide
        </label>
        <select 
          name="icon" 
          id="edit_cat_icon" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="book-open">Buku (book-open)</option>
          <option value="map-pin">Kewilayahan (map-pin)</option>
          <option value="trending-up">Ekonomi (trending-up)</option>
          <option value="users">Kependudukan (users)</option>
          <option value="sprout">Pertanian (sprout)</option>
          <option value="briefcase">Bisnis & Industri (briefcase)</option>
          <option value="compass">Pariwisata (compass)</option>
          <option value="activity">Kesehatan (activity)</option>
          <option value="graduation-cap">Pendidikan (graduation-cap)</option>
        </select>
      </div>

      <div>
        <label for="edit_cat_desc" class="block text-xs font-bold text-slate-700 mb-1.5">
          Deskripsi Kategori
        </label>
        <textarea 
          name="description" 
          id="edit_cat_desc" 
          rows="3" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        ></textarea>
      </div>

      <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button 
          type="button" 
          onclick="closeEditCategoryModal()" 
          class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
        >
          Batal
        </button>
        <button 
          type="submit" 
          class="inline-flex items-center gap-1.5 rounded-xl bg-[#082b62] px-5 py-2 text-xs font-bold text-white shadow-xs hover:bg-blue-900"
        >
          <i data-lucide="check" class="h-3.5 w-3.5"></i>
          <span>Simpan Perubahan</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Hapus Kategori -->
<div id="deleteCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
  <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl transition transform">
    <div class="flex items-center gap-3 text-rose-600 mb-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50">
        <i data-lucide="alert-triangle" class="h-5 w-5"></i>
      </span>
      <h3 class="text-base font-extrabold text-slate-900">Konfirmasi Hapus Kategori</h3>
    </div>

    <p id="deleteCategoryMessage" class="text-xs text-slate-600 leading-relaxed"></p>

    <div class="my-4 rounded-xl bg-slate-50 border border-slate-200 p-3">
      <p id="deleteCategoryName" class="text-xs font-bold text-slate-800"></p>
    </div>

    <form id="deleteCategoryForm" method="POST" action="">
      @csrf
      @method('DELETE')
      <div class="flex items-center justify-end gap-2.5">
        <button 
          type="button" 
          onclick="closeDeleteCategoryModal()" 
          class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
        >
          Batal
        </button>
        <button 
          id="confirmDeleteCategoryBtn"
          type="submit" 
          class="inline-flex items-center gap-1.5 rounded-xl bg-rose-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-rose-700 transition"
        >
          <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
          <span>Ya, Hapus Kategori</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function openAddCategoryModal() {
    const modal = document.getElementById('addCategoryModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }

  function closeAddCategoryModal() {
    const modal = document.getElementById('addCategoryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function openEditCategoryModal(id, name, desc, icon) {
    const modal = document.getElementById('editCategoryModal');
    const form = document.getElementById('editCategoryForm');
    form.action = `/admin/categories/${id}`;

    document.getElementById('edit_cat_name').value = name;
    document.getElementById('edit_cat_desc').value = desc;
    if (icon) {
      document.getElementById('edit_cat_icon').value = icon;
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }

  function closeEditCategoryModal() {
    const modal = document.getElementById('editCategoryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function openDeleteCategoryModal(deleteUrl, name, booksCount) {
    const modal = document.getElementById('deleteCategoryModal');
    const form = document.getElementById('deleteCategoryForm');
    const nameEl = document.getElementById('deleteCategoryName');
    const msgEl = document.getElementById('deleteCategoryMessage');
    const submitBtn = document.getElementById('confirmDeleteCategoryBtn');

    form.action = deleteUrl;
    nameEl.textContent = name;

    if (booksCount > 0) {
      msgEl.innerHTML = `<span class="text-rose-600 font-bold">Peringatan:</span> Kategori ini masih memiliki <strong>${booksCount} buku</strong> terhubung. Harap pindahkan atau hapus buku terlebih dahulu sebelum menghapus kategori ini.`;
      submitBtn.disabled = true;
      submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
      msgEl.textContent = 'Apakah Anda yakin ingin menghapus kategori ini?';
      submitBtn.disabled = false;
      submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }

  function closeDeleteCategoryModal() {
    const modal = document.getElementById('deleteCategoryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
@endpush
