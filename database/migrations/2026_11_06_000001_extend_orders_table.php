<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'hero_type')) {
                $table->string('hero_type')->nullable()->after('service_id');
            }
            if (!Schema::hasColumn('orders', 'hero_name')) {
                $table->string('hero_name')->nullable()->after('hero_type');
            }
            if (!Schema::hasColumn('orders', 'duration')) {
                $table->string('duration')->nullable()->after('hero_name');
            }
            if (!Schema::hasColumn('orders', 'children_count')) {
                $table->unsignedInteger('children_count')->nullable()->after('duration');
            }
            if (!Schema::hasColumn('orders', 'children_ages')) {
                $table->string('children_ages')->nullable()->after('children_count');
            }
            if (!Schema::hasColumn('orders', 'additional_services')) {
                $table->json('additional_services')->nullable()->after('children_ages');
            }
            if (!Schema::hasColumn('orders', 'apartment')) {
                $table->string('apartment')->nullable()->after('address');
            }
            if (!Schema::hasColumn('orders', 'fio')) {
                $table->string('fio')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'email')) {
                $table->string('email')->nullable()->after('fio');
            }
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'hero_type', 'hero_name', 'duration', 'children_count', 'children_ages',
                'additional_services', 'apartment', 'fio', 'email', 'phone'
            ]);
        });
    }
};
