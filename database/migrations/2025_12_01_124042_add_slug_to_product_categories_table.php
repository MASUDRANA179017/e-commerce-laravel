<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add slug column if it doesn't exist
        if (!Schema::hasColumn('product_categories', 'slug')) {
            Schema::table('product_categories', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name');
            });
        }

        // Generate slugs for existing categories
        $categories = DB::table('product_categories')->get();
        foreach ($categories as $category) {
            $slug = Str::slug($category->name);
            
            // Ensure unique slug
            $count = 1;
            $originalSlug = $slug;
            while (DB::table('product_categories')
                ->where('slug', $slug)
                ->where('id', '!=', $category->id)
                ->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            
            DB::table('product_categories')
                ->where('id', $category->id)
                ->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('product_categories', 'slug')) {
            Schema::table('product_categories', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
