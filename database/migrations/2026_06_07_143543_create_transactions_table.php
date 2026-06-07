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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->enum('type', ['income', 'expense']);

        $table->string('description');

        $table->string('category')->nullable();
        
        $table->decimal('amount', 15, 2);

        $table->string('receipt')->nullable();

        $table->date('transaction_date');

        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
