@extends('admin.layouts.app')

@section('title', 'Pengaturan Sistem')
@section('header_title', 'Pengaturan Perpustakaan & Akun')
@section('header_subtitle', 'Kelola identitas resmi perpustakaan digital, informasi kontak BPS, dan preferensi akun administrator.')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

  <!-- 1. General Library Settings Form -->
  <div class="rounded-3xl bg-white p-6 sm:p-8 border border-slate-200/90 shadow-xs">
    <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-[#082b62]">
        <i data-lucide="building" class="h-5 w-5"></i>
      </span>
      <div>
        <h2 class="text-base font-extrabold text-[#082b62]">Identitas & Informasi Perpustakaan</h2>
        <p class="text-xs text-slate-400">Pengaturan ini tampil pada header, hero section, dan footer situs publik.</p>
      </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <!-- Nama Perpustakaan -->
      <div>
        <label for="library_name" class="block text-xs font-bold text-slate-700 mb-1.5">
          Nama Perpustakaan Digital <span class="text-rose-500">*</span>
        </label>
        <input 
          type="text" 
          name="library_name" 
          id="library_name" 
          value="{{ old('library_name', $settings['library_name']) }}" 
          required 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
        @error('library_name')
          <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <!-- Tagline / Slogan -->
      <div>
        <label for="library_tagline" class="block text-xs font-bold text-slate-700 mb-1.5">
          Slogan / Tagline
        </label>
        <input 
          type="text" 
          name="library_tagline" 
          id="library_tagline" 
          value="{{ old('library_tagline', $settings['library_tagline']) }}" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <!-- Logo Perpustakaan Upload & Preview -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">
          Logo Resmi Perpustakaan
        </label>
        <div class="flex items-center gap-5 p-4 rounded-2xl bg-slate-50 border border-slate-200">
          <div class="h-14 w-14 shrink-0 rounded-xl bg-white p-2 border border-slate-200 flex items-center justify-center shadow-xs">
            <img 
              id="logoPreview" 
              src="{{ asset($settings['library_logo']) }}" 
              alt="Logo Perpustakaan" 
              class="h-full w-full object-contain"
              onerror="this.src='{{ asset('assets/images/logo-bps.svg') }}'"
            >
          </div>
          <div class="flex-1">
            <input 
              type="file" 
              name="logo" 
              id="logo" 
              accept="image/*"
              onchange="previewLogo(this)"
              class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#082b62] file:text-white hover:file:bg-blue-900 cursor-pointer"
            >
            <p class="text-[11px] text-slate-400 mt-1">Format gambar: SVG, PNG, atau WEBP transparan disarankan. Maks 2MB.</p>
          </div>
        </div>
        @error('logo')
          <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <!-- Deskripsi Perpustakaan -->
      <div>
        <label for="library_description" class="block text-xs font-bold text-slate-700 mb-1.5">
          Deskripsi & Profil Perpustakaan
        </label>
        <textarea 
          name="library_description" 
          id="library_description" 
          rows="3" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >{{ old('library_description', $settings['library_description']) }}</textarea>
      </div>

      <!-- Section: Data Kontak & Layanan -->
      <div class="pt-4 border-t border-slate-100">
        <h3 class="text-xs font-extrabold text-[#082b62] uppercase tracking-wider mb-4">
          Data Kontak & Jam Pelayanan
        </h3>

        <!-- Alamat Kantor -->
        <div class="mb-4">
          <label for="contact_address" class="block text-xs font-bold text-slate-700 mb-1.5">
            Alamat Kantor BPS
          </label>
          <input 
            type="text" 
            name="contact_address" 
            id="contact_address" 
            value="{{ old('contact_address', $settings['contact_address']) }}" 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
        </div>

        <!-- 3 Columns: Telepon, Email, WhatsApp -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
          <div>
            <label for="contact_phone" class="block text-xs font-bold text-slate-700 mb-1.5">
              Telepon Kantor
            </label>
            <input 
              type="text" 
              name="contact_phone" 
              id="contact_phone" 
              value="{{ old('contact_phone', $settings['contact_phone']) }}" 
              class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
            >
          </div>

          <div>
            <label for="contact_email" class="block text-xs font-bold text-slate-700 mb-1.5">
              Email Resmi
            </label>
            <input 
              type="email" 
              name="contact_email" 
              id="contact_email" 
              value="{{ old('contact_email', $settings['contact_email']) }}" 
              class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
            >
          </div>

          <div>
            <label for="contact_whatsapp" class="block text-xs font-bold text-slate-700 mb-1.5">
              Nomor WhatsApp Konsultasi
            </label>
            <input 
              type="text" 
              name="contact_whatsapp" 
              id="contact_whatsapp" 
              value="{{ old('contact_whatsapp', $settings['contact_whatsapp']) }}" 
              class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
            >
          </div>
        </div>

        <!-- Jam Pelayanan -->
        <div>
          <label for="service_hours" class="block text-xs font-bold text-slate-700 mb-1.5">
            Jam Pelayanan Statistik Terpadu (PST)
          </label>
          <input 
            type="text" 
            name="service_hours" 
            id="service_hours" 
            value="{{ old('service_hours', $settings['service_hours']) }}" 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
        </div>
      </div>

      <!-- Save Button -->
      <div class="pt-4 border-t border-slate-100 flex justify-end">
        <button 
          type="submit" 
          class="inline-flex items-center gap-2 rounded-xl bg-[#082b62] px-6 py-2.5 text-xs font-extrabold text-white shadow-md hover:bg-blue-900 transition active:scale-98"
        >
          <i data-lucide="check" class="h-4 w-4"></i>
          <span>Simpan Pengaturan Perpustakaan</span>
        </button>
      </div>

    </form>
  </div>

  <!-- 2. Admin Account Settings Form -->
  <div class="rounded-3xl bg-white p-6 sm:p-8 border border-slate-200/90 shadow-xs">
    <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-800">
        <i data-lucide="shield-check" class="h-5 w-5"></i>
      </span>
      <div>
        <h2 class="text-base font-extrabold text-[#082b62]">Pengaturan Akun Administrator</h2>
        <p class="text-xs text-slate-400">Perbarui profil administrator saat ini dan ubah kata sandi login.</p>
      </div>
    </div>

    <form action="{{ route('admin.settings.update_profile') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Admin Name & Email -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="admin_name" class="block text-xs font-bold text-slate-700 mb-1.5">
            Nama Lengkap Admin <span class="text-rose-500">*</span>
          </label>
          <input 
            type="text" 
            name="name" 
            id="admin_name" 
            value="{{ old('name', $currentAdmin->name) }}" 
            required 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('name')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="admin_email" class="block text-xs font-bold text-slate-700 mb-1.5">
            Alamat Email Login <span class="text-rose-500">*</span>
          </label>
          <input 
            type="email" 
            name="email" 
            id="admin_email" 
            value="{{ old('email', $currentAdmin->email) }}" 
            required 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('email')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Admin Phone -->
      <div>
        <label for="admin_phone" class="block text-xs font-bold text-slate-700 mb-1.5">
          Nomor Telepon Admin
        </label>
        <input 
          type="text" 
          name="phone" 
          id="admin_phone" 
          value="{{ old('phone', $currentAdmin->phone) }}" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <!-- Password Change Section -->
      <div class="pt-4 border-t border-slate-100">
        <h3 class="text-xs font-extrabold text-[#082b62] uppercase tracking-wider mb-2">
          Ganti Kata Sandi (Opsional)
        </h3>
        <p class="text-xs text-slate-400 mb-4">Kosongkan jika Anda tidak ingin mengubah kata sandi.</p>

        <div class="space-y-4">
          <div>
            <label for="current_password" class="block text-xs font-bold text-slate-700 mb-1.5">
              Kata Sandi Saat Ini
            </label>
            <input 
              type="password" 
              name="current_password" 
              id="current_password" 
              placeholder="Masukkan password saat ini untuk konfirmasi"
              class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
            >
            @error('current_password')
              <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="new_password" class="block text-xs font-bold text-slate-700 mb-1.5">
                Kata Sandi Baru
              </label>
              <input 
                type="password" 
                name="new_password" 
                id="new_password" 
                placeholder="Minimal 6 karakter"
                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
              >
              @error('new_password')
                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">
                Ulangi Kata Sandi Baru
              </label>
              <input 
                type="password" 
                name="new_password_confirmation" 
                id="new_password_confirmation" 
                placeholder="Ulangi kata sandi baru"
                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
              >
            </div>
          </div>
        </div>
      </div>

      <!-- Save Admin Profile -->
      <div class="pt-4 border-t border-slate-100 flex justify-end">
        <button 
          type="submit" 
          class="inline-flex items-center gap-2 rounded-xl bg-[#082b62] px-6 py-2.5 text-xs font-extrabold text-white shadow-md hover:bg-blue-900 transition active:scale-98"
        >
          <i data-lucide="check" class="h-4 w-4"></i>
          <span>Perbarui Akun Admin</span>
        </button>
      </div>

    </form>
  </div>

</div>
@endsection

@push('scripts')
<script>
  function previewLogo(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('logoPreview').src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush
