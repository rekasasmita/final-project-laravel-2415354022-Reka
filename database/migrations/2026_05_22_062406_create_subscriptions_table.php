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
    Schema::create('subscriptions', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel users dan services
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('service_id')->constrained()->cascadeOnDelete();
        $table->string('status')->default('active'); // active, expired, cancelled
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
