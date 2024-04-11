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
        Schema::create('crop_swap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained();
            $table->foreignId('swap_id')->constrained();
            $table->tinyInteger('quantity');
            $table->unique(['crop_id', 'swap_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_swap');
    }
};
