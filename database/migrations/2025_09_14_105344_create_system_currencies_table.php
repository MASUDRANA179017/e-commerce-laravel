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
        Schema::create('system_currencies', function (Blueprint $table) {
            $table->id();
            $table->enum('default_currency', ['BDT', 'USD', 'INR'])->default('BDT');
            $table->enum('fiscal_year_start', ['January', 'April', 'July', 'October'])->default('July');
            $table->decimal('usd_to_bdt_rate', 12, 6)->default(0);
            // enforce single row via unique boolean flag
            $table->boolean('singleton')->default(true);
            $table->unique('singleton');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });

        // seed the singleton row
        DB::table('system_currencies')->insert([
            'default_currency'  => 'BDT',
            'fiscal_year_start' => 'July',
            'usd_to_bdt_rate'   => 118.50,
            'singleton'         => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_currencies');
    }
};
