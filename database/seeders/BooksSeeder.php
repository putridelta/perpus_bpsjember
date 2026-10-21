<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'file_cover' => 'assets/images/books/cover1.webp',
                'file_books' => 'assets/file/pdf/file1.pdf',
                'name' => 'Kecamatan Sumber Baru Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Sumber Baru Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover2.webp',
                'file_books' => 'assets/file/pdf/file2.pdf',
                'name' => 'Kecamatan Silo Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Silo Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover3.webp',
                'file_books' => 'assets/file/pdf/file3.pdf',
                'name' => 'Kecamatan Rambipuji Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Rambipuji Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover4.webp',
                'file_books' => 'assets/file/pdf/file4.pdf',
                'name' => 'Produk Domestik Regional Bruto Kabupaten Jember Menurut Pengeluaran 2021-2025',
                'published_year' => '2026',
                'describe' => 'Produk Domestik Regional Bruto merupakan salah satu data ekonomi yang dapat digunakan untuk mengevaluasi kinerja pembangunan ekonomi suatu negara/wilayah',
                'category_id' => 2,
            ],
            [
                'file_cover' => 'assets/images/books/cover5.webp',
                'file_books' => 'assets/file/pdf/file5.pdf',
                'name' => 'Produk Domestik Regional Bruto Kabupaten Jember Menurut Lapangan Usaha 2021-2025',
                'published_year' => '2026',
                'describe' => 'Produk Domestik Regional Bruto merupakan salah satu data ekonomi yang dapat digunakan untuk mengevaluasi kinerja pembangunan ekonomi suatu negara/wilayah',
                'category_id' => 2,
            ],
            [
                'file_cover' => 'assets/images/books/cover1.webp',
                'file_books' => 'assets/file/pdf/file1.pdf',
                'name' => 'Kecamatan Sumber Baru Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Sumber Baru Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover3.webp',
                'file_books' => 'assets/file/pdf/file3.pdf',
                'name' => 'Kecamatan Rambipuji Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Rambipuji Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover2.webp',
                'file_books' => 'assets/file/pdf/file2.pdf',
                'name' => 'Kecamatan Silo Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Silo Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover5.webp',
                'file_books' => 'assets/file/pdf/file5.pdf',
                'name' => 'Produk Domestik Regional Bruto Kabupaten Jember Menurut Lapangan Usaha 2021-2025',
                'published_year' => '2026',
                'describe' => 'Produk Domestik Regional Bruto merupakan salah satu data ekonomi yang dapat digunakan untuk mengevaluasi kinerja pembangunan ekonomi suatu negara/wilayah',
                'category_id' => 2,
            ],
            [
                'file_cover' => 'assets/images/books/cover4.webp',
                'file_books' => 'assets/file/pdf/file4.pdf',
                'name' => 'Produk Domestik Regional Bruto Kabupaten Jember Menurut Pengeluaran 2021-2025',
                'published_year' => '2026',
                'describe' => 'Produk Domestik Regional Bruto merupakan salah satu data ekonomi yang dapat digunakan untuk mengevaluasi kinerja pembangunan ekonomi suatu negara/wilayah',
                'category_id' => 2,
            ],
            [
                'file_cover' => 'assets/images/books/cover2.webp',
                'file_books' => 'assets/file/pdf/file2.pdf',
                'name' => 'Kecamatan Silo Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Silo Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover3.webp',
                'file_books' => 'assets/file/pdf/file3.pdf',
                'name' => 'Kecamatan Rambipuji Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Rambipuji Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover5.webp',
                'file_books' => 'assets/file/pdf/file5.pdf',
                'name' => 'Produk Domestik Regional Bruto Kabupaten Jember Menurut Lapangan Usaha 2021-2025',
                'published_year' => '2026',
                'describe' => 'Produk Domestik Regional Bruto merupakan salah satu data ekonomi yang dapat digunakan untuk mengevaluasi kinerja pembangunan ekonomi suatu negara/wilayah',
                'category_id' => 2,
            ],
            [
                'file_cover' => 'assets/images/books/cover1.webp',
                'file_books' => 'assets/file/pdf/file1.pdf',
                'name' => 'Kecamatan Sumber Baru Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Sumber Baru Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
            [
                'file_cover' => 'assets/images/books/cover5.webp',
                'file_books' => 'assets/file/pdf/file5.pdf',
                'name' => 'Produk Domestik Regional Bruto Kabupaten Jember Menurut Lapangan Usaha 2021-2025',
                'published_year' => '2026',
                'describe' => 'Produk Domestik Regional Bruto merupakan salah satu data ekonomi yang dapat digunakan untuk mengevaluasi kinerja pembangunan ekonomi suatu negara/wilayah',
                'category_id' => 2,
            ],
            [
                'file_cover' => 'assets/images/books/cover2.webp',
                'file_books' => 'assets/file/pdf/file2.pdf',
                'name' => 'Kecamatan Silo Dalam Angka 2026',
                'published_year' => '2026',
                'describe' => 'Publikasi Kecamatan Silo Dalam Angka 2026 diterbitkan dalam rangka memenuhi kebutuhan akan pelayanan data statistik',
                'category_id' => 1,
            ],
        ];

        foreach ($books as $b) {
            Book::create($b);
        }
    }
}
