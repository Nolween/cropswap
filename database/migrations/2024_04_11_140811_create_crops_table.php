<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_permaculture')->default(false);
            $table->boolean('is_shared')->default(false);
            $table->boolean('is_pesticide_free')->default(false);
            $table->boolean('is_private')->default(true);
            $table->boolean('is_professional')->default(false);
            $table->boolean('can_give')->default(false);
            $table->boolean('can_swap')->default(false);
            $table->boolean('can_sell')->default(false);
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};
