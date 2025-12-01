<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('size_chart_templates', function (Blueprint $t) {
      $t->id();
      $t->foreignId('category_id')->nullable()
        ->constrained('categories')->nullOnDelete();
      $t->string('code')->unique();          // e.g. tee, hoodie, laptop-dim
      $t->string('name');                    // display name
      $t->string('unit', 16)->nullable();    // cm | inch | mm | null
      $t->json('columns');                   // ["Size","Chest",...]
      $t->json('rows');                      // [["S",48,70,...], ...]
      $t->text('notes')->nullable();
      $t->string('image_path')->nullable();
      $t->boolean('is_active')->default(true);
      $t->timestamps();
    });
  }
  public function down(): void 
    {
        Schema::dropIfExists('size_chart_templates');
    }
};
