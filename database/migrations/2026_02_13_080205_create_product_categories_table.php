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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("longtitle")->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('slug')->unique();
            $table->string("icon")->nullable();
            $table->string("description")->nullable();
            $table->string("image")->nullable();
            $table->string("thumbnail")->nullable();
            $table->text("content")->nullable();
            $table->boolean('published')->default(true);
            $table->boolean('show_in_menu')->default(true);
            $table->string("seo_title")->nullable();
            $table->string("seo_description")->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Связь с категориями
            $table->foreign('parent_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
