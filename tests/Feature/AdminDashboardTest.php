<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::firstOrCreate(
        ['email' => 'admin_test@bps.go.id'],
        [
            'name' => 'Admin Test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]
    );

    $this->category = Category::firstOrCreate(
        ['name' => 'Statistik Uji Coba'],
        ['slug' => 'statistik-uji-coba', 'icon' => 'book-open']
    );
});

test('visiting /admin as guest shows login form', function () {
    $response = $this->get('/admin');

    $response->assertStatus(200);
    $response->assertSee('Portal Admin Perpustakaan');
});

test('visiting /admin as logged-in admin redirects to dashboard', function () {
    $response = $this->actingAs($this->admin)->get('/admin');

    $response->assertRedirect(route('admin.dashboard'));
});

test('guest is redirected to admin login when accessing dashboard', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
});

test('admin can log in successfully', function () {
    $response = $this->post(route('admin.login.submit'), [
        'email' => 'admin_test@bps.go.id',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($this->admin);
});

test('admin can access dashboard and see overview cards', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Total Buku Publikasi');
    $response->assertSee('Aktivitas Membaca');
    $response->assertSee('Grafik Tren Aktivitas Membaca');
});

test('admin can create, view, edit and delete books', function () {
    // 1. Create
    $response = $this->actingAs($this->admin)->post(route('admin.books.store'), [
        'name' => 'Buku Uji Coba Statistik 2026',
        'author' => 'Tim BPS Jember',
        'publisher' => 'BPS Jember',
        'published_year' => 2026,
        'isbn' => '978-602-0000-01',
        'category_id' => $this->category->id,
        'describe' => 'Sinopsis buku pengujian sistem perpustakaan',
        'status' => 'published',
    ]);

    $response->assertRedirect(route('admin.books.index'));
    $this->assertDatabaseHas('books', ['name' => 'Buku Uji Coba Statistik 2026']);

    $book = Book::where('name', 'Buku Uji Coba Statistik 2026')->first();

    // 2. View
    $showResponse = $this->actingAs($this->admin)->get(route('admin.books.show', $book));
    $showResponse->assertStatus(200);
    $showResponse->assertSee('Buku Uji Coba Statistik 2026');

    // 3. Edit
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.books.update', $book), [
        'name' => 'Buku Uji Coba Statistik 2026 (Updated)',
        'author' => 'Tim BPS Jember Update',
        'publisher' => 'BPS Jember',
        'published_year' => 2026,
        'isbn' => '978-602-0000-01',
        'category_id' => $this->category->id,
        'describe' => 'Sinopsis buku diperbarui',
        'status' => 'published',
    ]);

    $updateResponse->assertRedirect(route('admin.books.index'));
    $this->assertDatabaseHas('books', ['name' => 'Buku Uji Coba Statistik 2026 (Updated)']);

    // 4. Delete
    $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.books.destroy', $book));
    $deleteResponse->assertRedirect(route('admin.books.index'));
    $this->assertDatabaseMissing('books', ['id' => $book->id]);
});

test('admin can manage users and toggle status', function () {
    $newUser = User::create([
        'name' => 'Member Test',
        'email' => 'member_test@example.com',
        'password' => Hash::make('password123'),
        'role' => 'user',
        'status' => 'active',
    ]);

    // View users list
    $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
    $response->assertStatus(200);
    $response->assertSee('Member Test');

    // Toggle status to inactive
    $toggleResponse = $this->actingAs($this->admin)->post(route('admin.users.toggle_status', $newUser));
    $toggleResponse->assertSessionHas('success');
    expect($newUser->fresh()->status)->toBe('inactive');

    // Delete user
    $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $newUser));
    $deleteResponse->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseMissing('users', ['id' => $newUser->id]);
});

test('admin can manage categories', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
        'name' => 'Kategori Baru Pengujian',
        'description' => 'Deskripsi pengujian kategori',
        'icon' => 'sprout',
    ]);

    $response->assertRedirect(route('admin.categories.index'));
    $this->assertDatabaseHas('categories', ['name' => 'Kategori Baru Pengujian']);

    $category = Category::where('name', 'Kategori Baru Pengujian')->first();

    // Delete category
    $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category));
    $deleteResponse->assertRedirect(route('admin.categories.index'));
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

test('admin can access reading logs and reports', function () {
    $logsResponse = $this->actingAs($this->admin)->get(route('admin.reading_logs.index'));
    $logsResponse->assertStatus(200);

    $reportsResponse = $this->actingAs($this->admin)->get(route('admin.reports.index'));
    $reportsResponse->assertStatus(200);
    $reportsResponse->assertSee('Laporan Kinerja Digital');

    $csvResponse = $this->actingAs($this->admin)->get(route('admin.reports.export_csv'));
    $csvResponse->assertStatus(200);
    expect($csvResponse->headers->get('content-type'))->toContain('text/csv');
});

test('admin can update settings', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
        'library_name' => 'Perpustakaan Digital BPS Jember Pengujian',
        'library_tagline' => 'Tagline Baru Uji Coba',
    ]);

    $response->assertRedirect(route('admin.settings.index'));
    $this->assertDatabaseHas('settings', [
        'key' => 'library_name',
        'value' => 'Perpustakaan Digital BPS Jember Pengujian',
    ]);
});
