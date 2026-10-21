<?php

use App\Models\Book;
use App\Models\Category;

beforeEach(function () {
    $this->category = Category::create([
        'name' => 'Kependudukan dan Gender',
    ]);

    $this->book = Book::create([
        'file_cover' => 'assets/images/cover-buku1.jpg',
        'file_books' => 'assets/file/pdf/file1.pdf',
        'name' => 'Kecamatan Kaliwates Dalam Angka 2026',
        'published_year' => 2026,
        'describe' => 'Publikasi Kecamatan Kaliwates Dalam Angka 2026 menyajikan statistik geografi dan kependudukan.',
        'category_id' => $this->category->id,
    ]);
});

test('halaman utama dapat diakses dan menampilkan buku dan kategori', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('PERPUSTAKAAN DIGITAL');
    $response->assertSee('Daftar Katalog');
    $response->assertSee('Kecamatan Kaliwates Dalam Angka 2026');
});

test('halaman daftar katalog dapat diakses dan menampilkan daftar buku', function () {
    $response = $this->get(route('katalog.index'));

    $response->assertStatus(200);
    $response->assertSee('Daftar Publikasi BPS');
    $response->assertSee('Kecamatan Kaliwates Dalam Angka 2026');
});

test('fitur pencarian katalog berfungsi dengan kata kunci', function () {
    $response = $this->get(route('katalog.index', ['search' => 'Kaliwates']));

    $response->assertStatus(200);
    $response->assertSee('Kecamatan Kaliwates Dalam Angka 2026');
});

test('fitur filter kategori pada katalog berfungsi', function () {
    $response = $this->get(route('katalog.index', ['kategori' => $this->category->id]));

    $response->assertStatus(200);
    $response->assertSee('Kecamatan Kaliwates Dalam Angka 2026');
});

test('fitur detail buku menampilkan informasi lengkap', function () {
    $response = $this->get(route('katalog.show', $this->book));

    $response->assertStatus(200);
    $response->assertSee('Kecamatan Kaliwates Dalam Angka 2026');
    $response->assertSee('Baca Buku Sekarang');
});

test('fitur baca membuka dokumen dan penampil baca interaktif', function () {
    $response = $this->get(route('baca.show', $this->book));

    $response->assertStatus(200);
    $response->assertSee('Kecamatan Kaliwates Dalam Angka 2026');
    $response->assertSee('Penampil Dokumen Digital BPS');
    $response->assertSee('Ringkasan Statistik');
});

test('api detail buku mengembalikan respon json untuk modal interaktif', function () {
    $response = $this->get(route('katalog.api', $this->book));

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $this->book->id,
        'name' => 'Kecamatan Kaliwates Dalam Angka 2026',
        'category' => 'Kependudukan dan Gender',
    ]);
});
