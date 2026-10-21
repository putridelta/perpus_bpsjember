@extends('admin.layouts.app')

@section('title', 'Tambah Buku Baru')
@section('header_title', 'Tambah Publikasi Baru')
@section('header_subtitle', 'Lengkapi data buku atau laporan statistik untuk dipublikasikan ke perpustakaan digital.')

@section('content')
<div class="max-w-4xl mx-auto">
  <div class="mb-4">
    <a href="{{ route('admin.books.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 hover:underline">
      <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
      <span>Kembali ke Daftar Buku</span>
    </a>
  </div>

  <div class="rounded-2xl bg-white p-6 sm:p-8 border border-slate-200/90 shadow-xs">
    <div class="border-b border-slate-100 pb-4 mb-6">
      <h2 class="text-base font-extrabold text-[#082b62]">Formulir Publikasi Buku Digital</h2>
      <p class="text-xs text-slate-400 mt-0.5">Isi seluruh informasi publikasi secara akurat.</p>
    </div>

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <!-- Judul Buku -->
      <div>
        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
          Judul Publikasi / Buku <span class="text-rose-500">*</span>
        </label>
        <input 
          type="text" 
          name="name" 
          id="name" 
          value="{{ old('name') }}" 
          required 
          placeholder="Contoh: Kabupaten Jember Dalam Angka 2026"
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
        @error('name')
          <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <!-- 2 Columns: Penulis & Penerbit -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="author" class="block text-xs font-bold text-slate-700 mb-1.5">
            Penulis / Tim Penyusun
          </label>
          <input 
            type="text" 
            name="author" 
            id="author" 
            value="{{ old('author', 'BPS Kabupaten Jember') }}" 
            placeholder="BPS Kabupaten Jember"
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('author')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="publisher" class="block text-xs font-bold text-slate-700 mb-1.5">
            Penerbit
          </label>
          <input 
            type="text" 
            name="publisher" 
            id="publisher" 
            value="{{ old('publisher', 'Badan Pusat Statistik Kabupaten Jember') }}" 
            placeholder="Badan Pusat Statistik Kabupaten Jember"
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('publisher')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- 3 Columns: Kategori, Tahun Terbit, ISBN -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
          <label for="category_id" class="block text-xs font-bold text-slate-700 mb-1.5">
            Kategori Publikasi <span class="text-rose-500">*</span>
          </label>
          <select 
            name="category_id" 
            id="category_id" 
            required 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="published_year" class="block text-xs font-bold text-slate-700 mb-1.5">
            Tahun Terbit <span class="text-rose-500">*</span>
          </label>
          <input 
            type="number" 
            name="published_year" 
            id="published_year" 
            value="{{ old('published_year', date('Y')) }}" 
            min="1990" 
            max="{{ date('Y') + 1 }}" 
            required 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('published_year')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="isbn" class="block text-xs font-bold text-slate-700 mb-1.5">
            Nomor ISBN / No Publikasi
          </label>
          <input 
            type="text" 
            name="isbn" 
            id="isbn" 
            value="{{ old('isbn') }}" 
            placeholder="978-602-5412-xx-x"
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('isbn')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Deskripsi / Sinopsis -->
      <div>
        <label for="describe" class="block text-xs font-bold text-slate-700 mb-1.5">
          Deskripsi & Sinopsis Buku <span class="text-rose-500">*</span>
        </label>
        <textarea 
          name="describe" 
          id="describe" 
          rows="4" 
          required 
          placeholder="Jelaskan ringkasan isi buku, cakupan data statistik, metodologi, dan tujuan penerbitan publikasi..."
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
        >{{ old('describe') }}</textarea>
        @error('describe')
          <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <!-- Status Publikasi -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-2">
          Status Publikasi <span class="text-rose-500">*</span>
        </label>
        <div class="flex items-center gap-6">
          <label class="flex items-center gap-2 cursor-pointer select-none text-xs text-slate-800">
            <input 
              type="radio" 
              name="status" 
              value="published" 
              {{ old('status', 'published') === 'published' ? 'checked' : '' }}
              class="text-blue-600 focus:ring-blue-500"
            >
            <span class="inline-flex items-center gap-1 font-semibold text-emerald-700">
              <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
              Published (Dapat dibaca publik)
            </span>
          </label>

          <label class="flex items-center gap-2 cursor-pointer select-none text-xs text-slate-800">
            <input 
              type="radio" 
              name="status" 
              value="draft" 
              {{ old('status') === 'draft' ? 'checked' : '' }}
              class="text-blue-600 focus:ring-blue-500"
            >
            <span class="inline-flex items-center gap-1 font-semibold text-slate-600">
              <span class="h-2 w-2 rounded-full bg-slate-400"></span>
              Draft (Hanya dapat dilihat admin)
            </span>
          </label>
        </div>
      </div>

      <!-- Upload Sampul & Upload File PDF -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2 border-t border-slate-100">
        
        <!-- File Cover -->
        <div>
          <label for="cover" class="block text-xs font-bold text-slate-700 mb-1.5">
            Unggah Gambar Sampul (Cover)
          </label>
          <div class="flex items-start gap-4">
            <div class="h-24 w-16 rounded-lg border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
              <img id="coverPreview" src="{{ asset('assets/images/cover-buku1.jpg') }}" alt="Preview" class="h-full w-full object-cover">
            </div>
            <div class="flex-1">
              <input 
                type="file" 
                name="cover" 
                id="cover" 
                accept="image/*"
                onchange="previewCoverImage(this)"
                class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#082b62] hover:file:bg-blue-100 cursor-pointer"
              >
              <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, atau WEBP. Maks 4MB.</p>
            </div>
          </div>
          @error('cover')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <!-- File PDF / E-book -->
        <div>
          <label for="file_book" class="block text-xs font-bold text-slate-700 mb-1.5">
            Unggah Berkas PDF / Dokumen E-Book
          </label>
          <div class="rounded-xl border border-dashed border-slate-300 p-4 bg-slate-50/50 text-center">
            <i data-lucide="file-text" class="mx-auto h-8 w-8 text-blue-600 mb-1"></i>
            <input 
              type="file" 
              name="file_book" 
              id="file_book" 
              accept=".pdf"
              class="block w-full text-xs text-slate-500 file:mr-auto file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#082b62] file:text-white hover:file:bg-blue-900 cursor-pointer"
            >
            <p class="text-[11px] text-slate-400 mt-1">Format dokumen: PDF (Maksimal 50MB).</p>
          </div>
          @error('file_book')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

      </div>

      <!-- Form Action Buttons -->
      <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
        <a 
          href="{{ route('admin.books.index') }}" 
          class="rounded-xl border border-slate-200 px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
        >
          Batal
        </a>
        <button 
          type="submit" 
          class="inline-flex items-center gap-2 rounded-xl bg-[#082b62] px-6 py-2.5 text-xs font-extrabold text-white shadow-md hover:bg-blue-900 transition active:scale-98"
        >
          <i data-lucide="save" class="h-4 w-4"></i>
          <span>Simpan & Terbitkan Buku</span>
        </button>
      </div>

    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function previewCoverImage(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('coverPreview').src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush
