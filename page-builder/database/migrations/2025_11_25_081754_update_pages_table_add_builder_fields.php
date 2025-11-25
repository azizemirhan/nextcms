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
        Schema::table('pages', function (Blueprint $table) {
            $table->enum('template_type', ['page', 'header', 'footer', 'single', 'archive', 'product', 'popup', '404'])
                ->default('page')
                ->after('status');
            $table->json('display_conditions')->nullable()->after('template_type');
            $table->boolean('is_template')->default(false)->after('display_conditions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['template_type', 'display_conditions', 'is_template']);
        });
    }
};
