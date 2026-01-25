<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_items', 'variant_id')) {
                $table->foreignId('variant_id')
                    ->nullable()
                    ->constrained('product_variants')
                    ->nullOnDelete()
                    ->after('product_id');
                $table->index('variant_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_items', 'variant_id')) {
                $table->dropConstrainedForeignId('variant_id');
            }
        });
    }
};

