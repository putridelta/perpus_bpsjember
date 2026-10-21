<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add fields to books table
        Schema::table('books', function (Blueprint $table) {
            if (! Schema::hasColumn('books', 'author')) {
                $table->string('author')->nullable()->default('BPS Kabupaten Jember')->after('name');
            }
            if (! Schema::hasColumn('books', 'publisher')) {
                $table->string('publisher')->nullable()->default('Badan Pusat Statistik Kabupaten Jember')->after('author');
            }
            if (! Schema::hasColumn('books', 'isbn')) {
                $table->string('isbn', 50)->nullable()->after('publisher');
            }
            if (! Schema::hasColumn('books', 'status')) {
                $table->string('status', 20)->default('published')->after('describe'); // 'published', 'draft'
            }
            if (! Schema::hasColumn('books', 'views_count')) {
                $table->unsignedBigInteger('views_count')->default(0)->after('status');
            }
        });

        // 2. Add fields to users table
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role', 20)->default('user')->after('password'); // 'admin', 'user'
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status', 20)->default('active')->after('role'); // 'active', 'inactive'
            }
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('status');
            }
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
        });

        // 3. Add fields to categories table
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (! Schema::hasColumn('categories', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (! Schema::hasColumn('categories', 'icon')) {
                $table->string('icon', 50)->nullable()->default('book-open')->after('description');
            }
        });

        // 4. Create reading_logs table
        if (! Schema::hasTable('reading_logs')) {
            Schema::create('reading_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
                $table->string('user_name')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->unsignedInteger('read_duration_minutes')->default(5);
                $table->string('activity_note')->default('Membaca Publikasi');
                $table->timestamps();
            });
        }

        // 5. Create favorites table
        if (! Schema::hasTable('favorites')) {
            Schema::create('favorites', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['user_id', 'book_id']);
            });
        }

        // 6. Create settings table
        if (! Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->longText('value')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('reading_logs');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description', 'icon']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'phone', 'avatar']);
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['author', 'publisher', 'isbn', 'status', 'views_count']);
        });
    }
};
