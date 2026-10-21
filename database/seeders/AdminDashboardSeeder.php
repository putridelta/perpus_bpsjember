<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\ReadingLog;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminDashboardSeeder extends Seeder
{
    /**
     * Seed initial admin data, users, reading logs, favorites, and settings.
     */
    public function run(): void
    {
        // 1. Ensure Categories exist and have slugs and icons
        $categoriesData = [
            ['name' => 'Statistik Umum & Kecamatan', 'icon' => 'map-pin', 'description' => 'Koleksi publikasi Kecamatan Dalam Angka dan data kewilayahan Kabupaten Jember.'],
            ['name' => 'Ekonomi & PDRB', 'icon' => 'trending-up', 'description' => 'Produk Domestik Regional Bruto, pertumbuhan ekonomi, inflasi, dan keuangan daerah.'],
            ['name' => 'Sosial & Kependudukan', 'icon' => 'users', 'description' => 'Data sensus penduduk, ketenagakerjaan, kemiskinan, dan Indeks Pembangunan Manusia.'],
            ['name' => 'Pertanian & Perkebunan', 'icon' => 'sprout', 'description' => 'Statistik komoditas pertanian, hortikultura, perkebunan tembakau, dan ketahanan pangan.'],
            ['name' => 'Pariwisata & Transportasi', 'icon' => 'compass', 'description' => 'Data kunjungan wisatawan, perhotelan, sarana transportasi, dan mobilitas penduduk.'],
        ];

        foreach ($categoriesData as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name']],
                [
                    'slug' => Str::slug($cat['name']),
                    'icon' => $cat['icon'],
                    'description' => $cat['description'],
                ]
            );
        }

        // 2. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@bps.go.id'],
            [
                'name' => 'Admin Perpustakaan BPS',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'phone' => '081234567890',
            ]
        );

        // 3. Regular Users / Members
        $usersData = [
            ['name' => 'Ahmad Fauzi', 'email' => 'fauzi@unej.ac.id', 'role' => 'user', 'status' => 'active', 'phone' => '082143556789'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.nur@polije.ac.id', 'role' => 'user', 'status' => 'active', 'phone' => '081333445566'],
            ['name' => 'Bambang Supriyanto', 'email' => 'bambang.s@pemkabjember.go.id', 'role' => 'user', 'status' => 'active', 'phone' => '085234567812'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.lestari@gmail.com', 'role' => 'user', 'status' => 'active', 'phone' => '087856341290'],
            ['name' => 'Rian Hidayat', 'email' => 'rian.hidayat@student.ub.ac.id', 'role' => 'user', 'status' => 'active', 'phone' => '089678432101'],
            ['name' => 'Putri Ayu Wulandari', 'email' => 'putri.ayu@gmail.com', 'role' => 'user', 'status' => 'inactive', 'phone' => '081290876543'],
            ['name' => 'Hendra Setiawan', 'email' => 'hendra.st@bps.go.id', 'role' => 'admin', 'status' => 'active', 'phone' => '081398765432'],
        ];

        $createdUsers = [$admin];
        foreach ($usersData as $ud) {
            $createdUsers[] = User::firstOrCreate(
                ['email' => $ud['email']],
                [
                    'name' => $ud['name'],
                    'password' => Hash::make('password123'),
                    'role' => $ud['role'],
                    'status' => $ud['status'],
                    'phone' => $ud['phone'],
                ]
            );
        }

        // 4. Ensure Books have complete metadata
        $books = Book::all();
        if ($books->isEmpty()) {
            $seeder = new BooksSeeder;
            $seeder->run();
            $books = Book::all();
        }

        $isbns = [
            '978-602-5412-01-2', '978-602-5412-02-9', '978-602-5412-03-6',
            '978-602-5412-04-3', '978-602-5412-05-0', '978-602-5412-06-7',
            '978-602-5412-07-4', '978-602-5412-08-1', '978-602-5412-09-8',
        ];

        $statuses = ['published', 'published', 'published', 'published', 'published', 'draft'];

        foreach ($books as $index => $book) {
            $book->author = $book->author ?: 'BPS Kabupaten Jember';
            $book->publisher = $book->publisher ?: 'Badan Pusat Statistik Kabupaten Jember';
            $book->isbn = $book->isbn ?: ($isbns[$index % count($isbns)] ?? '978-602-5412-'.str_pad($index, 2, '0', STR_PAD_LEFT));
            $book->status = $book->status ?: $statuses[$index % count($statuses)];
            $book->views_count = $book->views_count ?: rand(45, 480);
            $book->save();
        }

        // 5. Seed Reading Logs for realistic dashboard statistics
        if (ReadingLog::count() < 30) {
            $now = Carbon::now();
            $activities = [
                'Membaca Bab Indikator Utama',
                'Membaca Tabel Statistik Wilayah',
                'Melihat Ringkasan Eksekutif',
                'Mengunduh Lampiran Data',
                'Membaca Publikasi Lengkap',
                'Melihat Grafik Pertumbuhan',
            ];

            // Generate logs across the past 30 days
            for ($i = 0; $i < 65; $i++) {
                $randomBook = $books->random();
                $randomUser = $createdUsers[array_rand($createdUsers)];
                $daysAgo = rand(0, 29);
                $hoursAgo = rand(1, 23);
                $logTime = $now->copy()->subDays($daysAgo)->subHours($hoursAgo);

                ReadingLog::create([
                    'user_id' => $randomUser->id,
                    'book_id' => $randomBook->id,
                    'user_name' => $randomUser->name,
                    'ip_address' => '192.168.1.'.rand(10, 220),
                    'read_duration_minutes' => rand(3, 45),
                    'activity_note' => $activities[array_rand($activities)],
                    'created_at' => $logTime,
                    'updated_at' => $logTime,
                ]);
            }
        }

        // 6. Seed Favorites / Bookmarks
        if (Favorite::count() < 15) {
            foreach ($createdUsers as $user) {
                // Each user favorites 2-4 distinct books
                $favBooks = $books->random(min(rand(2, 4), $books->count()));
                foreach ($favBooks as $b) {
                    Favorite::firstOrCreate([
                        'user_id' => $user->id,
                        'book_id' => $b->id,
                    ]);
                }
            }
        }

        // 7. Seed Settings
        $settings = [
            'library_name' => 'Perpustakaan Digital BPS Kabupaten Jember',
            'library_tagline' => 'Akses Publikasi Statistik Resmi, Data, dan Indikator Daerah Terpercaya',
            'library_description' => 'Sistem perpustakaan digital terintegrasi Badan Pusat Statistik Kabupaten Jember yang melayani penyediaan literatur statistik daerah, laporan PDRB, data kecamatan dalam angka, dan publikasi sensus secara terbuka, cepat, dan akuntabel.',
            'contact_address' => 'Jl. Kartini No. 19, Kepatihan, Kec. Kaliwates, Kabupaten Jember, Jawa Timur 68131',
            'contact_phone' => '(0331) 487532',
            'contact_email' => 'bps3509@bps.go.id',
            'contact_whatsapp' => '0812-3456-7890',
            'service_hours' => 'Senin – Kamis: 08.00 – 15.30 WIB | Jumat: 08.00 – 15.00 WIB (Sabtu, Minggu & Hari Libur Tutup)',
            'library_logo' => 'assets/images/logo-bps.svg',
        ];

        foreach ($settings as $k => $v) {
            Setting::set($k, $v);
        }
    }
}
