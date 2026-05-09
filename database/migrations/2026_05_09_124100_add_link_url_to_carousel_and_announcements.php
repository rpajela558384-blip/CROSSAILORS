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
        Schema::table('carousel_items', function (Blueprint $table) {
            $table->string('link_url')->nullable()->after('caption');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('link_url')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('carousel_items', function (Blueprint $table) {
            $table->dropColumn('link_url');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('link_url');
        });
    }
};
