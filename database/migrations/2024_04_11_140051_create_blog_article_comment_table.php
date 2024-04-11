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
        Schema::create('blog_article_comment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_article_id');
            $table->text('content');
            $table->unsignedBigInteger('user_id');
            $table->foreign('blog_article_id')->references('id')->on('blog_articles');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_article_comment');
    }
};
