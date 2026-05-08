<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->bigInteger('amount');
            $table->enum('type', ['income', 'expense'])->default('expense');
            $table->string('icon')->nullable(); // Opsional untuk UI yang lebih menarik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_templates');
    }
};
