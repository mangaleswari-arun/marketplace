<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->enum('type', ['product', 'service']);
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('detail');
            $table->string('country', 100);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->string('area', 150)->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->enum('status', ['draft', 'published', 'rejected'])->default('published');
            $table->timestamps();
            $table->index(['status', 'category_id', 'city']);
            $table->index(['country', 'state', 'city']);
            $table->fullText(['name', 'detail']);
        });
    }

    public function down(): void { Schema::dropIfExists('listings'); }
};
