<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Statistik - {{ $libraryName }}</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo-bps.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])

  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #0f172a;
      background: #ffffff;
    }
    @media print {
      .no-print {
        display: none !important;
      }
      body {
        margin: 0;
        padding: 0;
      }
      @page {
        margin: 1.5cm;
      }
    }
  </style>
</head>
<body class="p-6 sm:p-10 max-w-5xl mx-auto">

  <!-- Print Actions Bar (Hidden on print) -->
  <div class="no-print mb-8 p-4 rounded-2xl bg-blue-50 border border-blue-200 flex items-center justify-between">
    <div>
      <h3 class="text-sm font-extrabold text-[#082b62]">Pratinjau Dokumen Laporan</h3>
      <p class="text-xs text-slate-500">Gunakan tombol cetak untuk mencetak ke printer fisik atau menyimpan sebagai file PDF.</p>
    </div>
    <div class="flex items-center gap-2">
      <button 
        type="button" 
        onclick="window.print()" 
        class="inline-flex items-center gap-2 rounded-xl bg-[#082b62] px-5 py-2.5 text-xs font-extrabold text-white shadow-md hover:bg-blue-900 transition"
      >
        <span>Cetak Sekarang (Print / PDF)</span>
      </button>
      <button 
        type="button" 
        onclick="window.close()" 
        class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50"
      >
        Tutup
      </button>
    </div>
  </div>

  <!-- Official Letterhead (Kop Surat) -->
  <div class="border-b-2 border-slate-900 pb-5 mb-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
      <img src="{{ asset('assets/images/logo-bps.svg') }}" alt="Logo BPS" class="h-16 w-16 object-contain">
      <div>
        <h1 class="text-base sm:text-lg font-black uppercase tracking-wider text-slate-900 leading-tight">
          BADAN PUSAT STATISTIK KABUPATEN JEMBER
        </h1>
        <h2 class="text-xs font-extrabold text-blue-900 uppercase tracking-widest mt-0.5">
          SISTEM PERPUSTAKAAN DIGITAL & DISEMINASI INFORMASI STATISTIK DAERAH
        </h2>
        <p class="text-[11px] text-slate-500 mt-1">
          {{ $libraryAddress }} &bull; Telepon: (0331) 487532 &bull; Website: jemberkab.bps.go.id
        </p>
      </div>
    </div>
  </div>

  <!-- Document Title & Metadata -->
  <div class="text-center my-6">
    <h3 class="text-base font-black uppercase tracking-wide text-slate-900 underline underline-offset-4">
      LAPORAN STATISTIK & AKTIVITAS PERPUSTAKAAN
    </h3>
    <p class="text-xs text-slate-600 mt-1">
      Periode Laporan: <strong>{{ $periodLabel }}</strong> &bull; Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
    </p>
  </div>

  <!-- Summary KPI Table -->
  <div class="my-6">
    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">1. Ringkasan Eksekutif Data</h4>
    <div class="grid grid-cols-4 gap-4 text-center">
      <div class="rounded-xl border border-slate-300 p-3">
        <span class="text-[11px] text-slate-500 font-semibold block">Total Buku</span>
        <span class="text-lg font-black text-slate-900 block mt-1">{{ number_format($totalBooks) }}</span>
      </div>
      <div class="rounded-xl border border-slate-300 p-3">
        <span class="text-[11px] text-slate-500 font-semibold block">Total Pengguna</span>
        <span class="text-lg font-black text-slate-900 block mt-1">{{ number_format($totalUsers) }}</span>
      </div>
      <div class="rounded-xl border border-slate-300 p-3">
        <span class="text-[11px] text-slate-500 font-semibold block">Kategori Rumpun</span>
        <span class="text-lg font-black text-slate-900 block mt-1">{{ $categories->count() }}</span>
      </div>
      <div class="rounded-xl border border-slate-300 p-3">
        <span class="text-[11px] text-slate-500 font-semibold block">Total Sesi Membaca</span>
        <span class="text-lg font-black text-blue-900 block mt-1">{{ number_format($totalReads) }}</span>
      </div>
    </div>
  </div>

  <!-- Top Books Table -->
  <div class="my-6">
    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">2. Publikasi Paling Banyak Dibaca</h4>
    <table class="w-full text-left text-xs border border-slate-300 border-collapse">
      <thead class="bg-slate-100 font-bold border-b border-slate-300">
        <tr>
          <th class="p-2 w-10 text-center border-r border-slate-300">No</th>
          <th class="p-2 border-r border-slate-300">Judul Publikasi Statistik</th>
          <th class="p-2 border-r border-slate-300">Kategori</th>
          <th class="p-2 text-center border-r border-slate-300">Tahun</th>
          <th class="p-2 text-center">Sesi Membaca</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200">
        @foreach($topBooks as $index => $b)
          <tr>
            <td class="p-2 text-center border-r border-slate-200">{{ $index + 1 }}</td>
            <td class="p-2 font-bold text-slate-900 border-r border-slate-200">{{ $b->name }}</td>
            <td class="p-2 border-r border-slate-200">{{ $b->category?->name ?? 'Statistik' }}</td>
            <td class="p-2 text-center border-r border-slate-200">{{ $b->published_year }}</td>
            <td class="p-2 text-center font-bold text-blue-900">{{ $b->reading_logs_count }} kali</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Recent Logs Samples -->
  <div class="my-6">
    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">3. Rekapitulasi Pembaca Terkini (Sampel 25 Aktivitas)</h4>
    <table class="w-full text-left text-xs border border-slate-300 border-collapse">
      <thead class="bg-slate-100 font-bold border-b border-slate-300">
        <tr>
          <th class="p-2 w-10 text-center border-r border-slate-300">No</th>
          <th class="p-2 border-r border-slate-300">Waktu</th>
          <th class="p-2 border-r border-slate-300">Nama Pengguna</th>
          <th class="p-2 border-r border-slate-300">Buku Yang Dibaca</th>
          <th class="p-2 border-r border-slate-300">Aktivitas</th>
          <th class="p-2 text-center">Durasi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200">
        @foreach($recentLogs as $index => $log)
          <tr>
            <td class="p-2 text-center border-r border-slate-200">{{ $index + 1 }}</td>
            <td class="p-2 border-r border-slate-200">{{ $log->created_at->format('d/m/Y H:i') }}</td>
            <td class="p-2 font-semibold border-r border-slate-200">{{ $log->user ? $log->user->name : ($log->user_name ?: 'Pengunjung') }}</td>
            <td class="p-2 border-r border-slate-200">{{ $log->book ? $log->book->name : 'Buku' }}</td>
            <td class="p-2 border-r border-slate-200">{{ $log->activity_note }}</td>
            <td class="p-2 text-center">{{ $log->read_duration_minutes }} menit</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Signature Block -->
  <div class="mt-12 pt-6 flex justify-end">
    <div class="text-center w-64 text-xs">
      <p>Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
      <p class="font-bold text-slate-900 mt-1">Kepala BPS Kabupaten Jember</p>
      <div class="h-20"></div>
      <p class="font-bold underline text-slate-900">Dr. Ir. Pengelola Statistik, M.Si.</p>
      <p class="text-slate-500">NIP. 19780101 200212 1 001</p>
    </div>
  </div>

</body>
</html>
