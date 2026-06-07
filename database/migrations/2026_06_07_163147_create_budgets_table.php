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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            // Terikat ke user yang login
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Menyimpan teks string kategori ('Marketing', 'Operations', dll)
            $table->string('category_name'); 
            
            // Batas maksimal anggaran
            $table->decimal('allocated_amount', 15, 2); 
            
            // Penanda bulan dan tahun budget (contoh: '2026-06')
            $table->string('month_year'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
