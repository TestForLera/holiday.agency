<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'hero_image')) {
                $table->string('hero_image')->nullable()->after('hero_subtitle');
            }
            if (!Schema::hasColumn('settings', 'promo_code')) {
                $table->string('promo_code')->nullable()->after('hero_image');
            }
            if (!Schema::hasColumn('settings', 'promo_text')) {
                $table->string('promo_text')->nullable()->after('promo_code');
            }
            if (!Schema::hasColumn('settings', 'why_us_title')) {
                $table->string('why_us_title')->nullable();
            }
            if (!Schema::hasColumn('settings', 'why_us_text')) {
                $table->text('why_us_text')->nullable();
            }
            if (!Schema::hasColumn('settings', 'main_text')) {
                $table->string('main_text')->nullable();
            }
        });

        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('reviews', 'order_id')) {
                $table->foreignId('order_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('reviews', 'comment')) {
                $table->text('comment')->nullable();
            }
            if (!Schema::hasColumn('reviews', 'is_published')) {
                $table->boolean('is_published')->default(true);
            }
            if (!Schema::hasColumn('reviews', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });

        Schema::table('heroes', function (Blueprint $table) {
            if (!Schema::hasColumn('heroes', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('heroes', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_active');
            }
        });

        Schema::table('slaider', function (Blueprint $table) {
            if (!Schema::hasColumn('slaider', 'text')) {
                $table->text('text')->nullable()->after('title');
            }
            if (!Schema::hasColumn('slaider', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
        });
    }

    public function down(): void
    {
        //
    }
};
