<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSamplePdfs extends Command
{
    protected $signature = 'app:generate-sample-pdfs';

    protected $description = 'Generate valid sample BPS publication PDF files';

    public function handle(): int
    {
        $dir = public_path('assets/file/pdf');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $publications = [
            'file1.pdf' => [
                'title' => 'Kecamatan Sumber Baru Dalam Angka 2026',
                'category' => 'Kab Jember dalam Angka',
                'sections' => [
                    'Kondisi Geografis: Luas wilayah, batas administrasi, dan iklim tropis.',
                    'Pemerintahan: 10 Desa/Kelurahan terlayani secara optimal dengan perangkat desa lengkap.',
                    'Kependudukan: Jumlah penduduk 112.450 jiwa dengan laju pertumbuhan 0.85% per tahun.',
                    'Perekonomian & Pertanian: Komoditas unggulan berupa padi, jagung, dan tebu.',
                ],
            ],
            'file2.pdf' => [
                'title' => 'Kecamatan Silo Dalam Angka 2026',
                'category' => 'Kab Jember dalam Angka',
                'sections' => [
                    'Kondisi Geografis: Berada di wilayah perbukitan dengan ketinggian 400-900 mdpl.',
                    'Pemerintahan: Terdiri dari 9 Desa dengan pelayanan administrasi terpadu.',
                    'Kependudukan: Penduduk berjumlah 108.320 jiwa dengan kepadatan 850 jiwa/km2.',
                    'Perkebunan: Sentra produksi kopi robusta dan cengkeh Jawa Timur.',
                ],
            ],
            'file3.pdf' => [
                'title' => 'Kecamatan Rambipuji Dalam Angka 2026',
                'category' => 'Kab Jember dalam Angka',
                'sections' => [
                    'Kondisi Geografis: Wilayah dataran rendah yang subur di lintas barat Jember.',
                    'Pemerintahan: 8 Desa dengan infrastruktur jalan dan transportasi strategis.',
                    'Kependudukan: Penduduk berjumlah 88.640 jiwa dengan indeks pembangunan manusia tinggi.',
                    'Perdagangan & UMKM: Sentra industri kecil dan perdagangan antarkota.',
                ],
            ],
            'file4.pdf' => [
                'title' => 'Produk Domestik Regional Bruto Kabupaten Jember Menurut Pengeluaran 2021-2025',
                'category' => 'Domestik & PDRB',
                'sections' => [
                    'Konsumsi Rumah Tangga: Menyumbang lebih dari 62% terhadap total PDRB Kabupaten Jember.',
                    'Pembentukan Modal Tetap Bruto (PMTB): Mengalami kenaikan 5.4% didorong investasi infrastruktur.',
                    'Konsumsi Pemerintah: Realisasi belanja publik mendukung percepatan pemulihan ekonomi daerah.',
                    'Ekspor Bersih: Kinerja ekspor produk perkebunan dan olahan tembakau tetap positif.',
                ],
            ],
            'file5.pdf' => [
                'title' => 'Produk Domestik Regional Bruto Kabupaten Jember Menurut Lapangan Usaha 2021-2025',
                'category' => 'Ekonomi & Lapangan Usaha',
                'sections' => [
                    'Sektor Pertanian, Kehutanan, & Perikanan: Masih menjadi penopang utama ekonomi Jember (27.8%).',
                    'Industri Pengolahan: Kontribusi stabil di angka 18.2% dengan pertumbuhan 4.8%.',
                    'Perdagangan Besar & Eceran: Tumbuh positif seiring pemulihan aktivitas pasar tradisional dan modern.',
                    'Transportasi & Pergudangan: Mengalami lonjakan pertumbuhan seiring konektivitas jalur selatan.',
                ],
            ],
        ];

        foreach ($publications as $filename => $info) {
            $pdfContent = $this->createPdfDocument($info['title'], $info['category'], $info['sections']);
            file_put_contents($dir.'/'.$filename, $pdfContent);
            $this->info("Generated: {$filename}");
        }

        return Command::SUCCESS;
    }

    private function createPdfDocument(string $title, string $category, array $sections): string
    {
        $objects = [];

        // 1: Catalog
        $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';

        // 2: Pages
        $objects[2] = '<< /Type /Pages /Kids [3 0 R 4 0 R] /Count 2 >>';

        // 5 & 6: Fonts
        $objects[5] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>';
        $objects[6] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';

        // Page 1: Cover & Intro
        $page1Stream = "BT\n";
        $page1Stream .= "/F1 20 Tf\n";
        $page1Stream .= "50 780 Td\n(BADAN PUSAT STATISTIK KABUPATEN JEMBER) Tj\n";
        $page1Stream .= "/F2 12 Tf\n";
        $page1Stream .= "0 -25 Td\n(Koleksi Perpustakaan Digital - Publikasi Resmi Statistik) Tj\n";
        $page1Stream .= "0 -15 Td\n(Jl. Kartini No. 19, Jember, Jawa Timur | Telp: (0331) 487532) Tj\n";

        $page1Stream .= "/F1 16 Tf\n";
        $page1Stream .= "0 -55 Td\n(".$this->sanitizeForPdf($title).") Tj\n";
        $page1Stream .= "/F2 12 Tf\n";
        $page1Stream .= "0 -25 Td\n(Kategori: ".$this->sanitizeForPdf($category)." | Tahun Terbit: 2026) Tj\n";

        $page1Stream .= "/F1 13 Tf\n";
        $page1Stream .= "0 -45 Td\n(KATA PENGANTAR) Tj\n";
        $page1Stream .= "/F2 11 Tf\n";
        $page1Stream .= "0 -22 Td\n(Publikasi ini merupakan seri publikasi tahunan yang disajikan secara berkala) Tj\n";
        $page1Stream .= "0 -18 Td\n(oleh Badan Pusat Statistik Kabupaten Jember untuk menyajikan gambaran komprehensif) Tj\n";
        $page1Stream .= "0 -18 Td\n(mengenai keadaan geografi, kependudukan, sosial, serta perkembangan ekonomi di wilayah ini.) Tj\n";
        $page1Stream .= "0 -18 Td\n(Data yang termuat dihimpun melalui sensus, survei rutin, serta catatan administratif) Tj\n";
        $page1Stream .= "0 -18 Td\n(dari berbagai instansi pemerintah dan swasta terkait.) Tj\n";

        $page1Stream .= "/F1 13 Tf\n";
        $page1Stream .= "0 -40 Td\n(RINGKASAN EKSEKUTIF) Tj\n";
        $page1Stream .= "/F2 11 Tf\n";
        foreach ($sections as $sec) {
            $page1Stream .= "0 -22 Td\n(- ".$this->sanitizeForPdf($sec).") Tj\n";
        }

        $page1Stream .= "0 -40 Td\n(Dokumen ini dapat dibaca dan digunakan untuk keperluan riset, akademis, dan perencanaan pembangunan.) Tj\n";
        $page1Stream .= "ET\n";

        $objects[7] = '<< /Length '.strlen($page1Stream)." >>\nstream\n".$page1Stream.'endstream';
        $objects[3] = '<< /Type /Page /Parent 2 0 R /Resources << /Font << /F1 5 0 R /F2 6 0 R >> >> /MediaBox [0 0 595 842] /Contents 7 0 R >>';

        // Page 2: Detailed Table & Indicators
        $page2Stream = "BT\n";
        $page2Stream .= "/F1 16 Tf\n";
        $page2Stream .= "50 780 Td\n(TABEL INDIKATOR UTAMA KABUPATEN JEMBER) Tj\n";
        $page2Stream .= "/F2 11 Tf\n";
        $page2Stream .= "0 -25 Td\n(Berikut adalah rangkuman data pokok dan indikator statistik penting:) Tj\n";

        $page2Stream .= "/F1 11 Tf\n";
        $page2Stream .= "0 -35 Td\n(1. Indikator Kependudukan & Ketenagakerjaan:) Tj\n";
        $page2Stream .= "/F2 10 Tf\n";
        $page2Stream .= "0 -18 Td\n(   - Jumlah Penduduk Kabupaten Jember : 2.585.120 Jiwa) Tj\n";
        $page2Stream .= "0 -16 Td\n(   - Tingkat Partisipasi Angkatan Kerja (TPAK) : 71.42%) Tj\n";
        $page2Stream .= "0 -16 Td\n(   - Tingkat Pengangguran Terbuka (TPT) : 4.01%) Tj\n";

        $page2Stream .= "/F1 11 Tf\n";
        $page2Stream .= "0 -30 Td\n(2. Indikator Makro Ekonomi & PDRB:) Tj\n";
        $page2Stream .= "/F2 10 Tf\n";
        $page2Stream .= "0 -18 Td\n(   - Laju Pertumbuhan Ekonomi : 5.15% (y-on-y)) Tj\n";
        $page2Stream .= "0 -16 Td\n(   - PDRB Atas Dasar Harga Berlaku (ADHB) : Rp 92.45 Triliun) Tj\n";
        $page2Stream .= "0 -16 Td\n(   - Inflasi Tahunan Kabupaten Jember : 2.45%) Tj\n";

        $page2Stream .= "/F1 11 Tf\n";
        $page2Stream .= "0 -30 Td\n(3. Kesejahteraan & Sosial:) Tj\n";
        $page2Stream .= "/F2 10 Tf\n";
        $page2Stream .= "0 -18 Td\n(   - Indeks Pembangunan Manusia (IPM) : 70.82) Tj\n";
        $page2Stream .= "0 -16 Td\n(   - Angka Harapan Hidup : 72.15 Tahun) Tj\n";
        $page2Stream .= "0 -16 Td\n(   - Rata-rata Lama Sekolah : 7.64 Tahun) Tj\n";

        $page2Stream .= "/F1 10 Tf\n";
        $page2Stream .= "0 -50 Td\n(Disusun oleh: Seksi Integrasi Pengolahan dan Diseminasi Statistik (IPDS)) Tj\n";
        $page2Stream .= "0 -16 Td\n(Badan Pusat Statistik Kabupaten Jember) Tj\n";
        $page2Stream .= "0 -16 Td\n(Hak Cipta Dilindungi Undang-Undang | https://jemberkab.bps.go.id) Tj\n";
        $page2Stream .= "ET\n";

        $objects[8] = '<< /Length '.strlen($page2Stream)." >>\nstream\n".$page2Stream.'endstream';
        $objects[4] = '<< /Type /Page /Parent 2 0 R /Resources << /Font << /F1 5 0 R /F2 6 0 R >> >> /MediaBox [0 0 595 842] /Contents 8 0 R >>';

        // Assemble PDF
        $pdf = "%PDF-1.4\n";
        $offsets = [];
        ksort($objects);

        foreach ($objects as $num => $obj) {
            $offsets[$num] = strlen($pdf);
            $pdf .= "{$num} 0 obj\n{$obj}\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $count = count($objects) + 1;
        $pdf .= "xref\n";
        $pdf .= "0 {$count}\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i < $count; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n";
        $pdf .= "<< /Size {$count} /Root 1 0 R >>\n";
        $pdf .= "startxref\n";
        $pdf .= "{$xrefOffset}\n";
        $pdf .= "%%EOF\n";

        return $pdf;
    }

    private function sanitizeForPdf(string $text): string
    {
        return str_replace(['(', ')', '\\'], ['', '', ''], $text);
    }
}
