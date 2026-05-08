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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text("article")->nullable();
            $table->string("title");
            $table->string("longtitle")->nullable();
            $table->decimal("price")->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            $table->string('slug')->unique();
            $table->string("description")->nullable();
            $table->string("image")->nullable();
            $table->string("thumbnail")->nullable();
            $table->text("content")->nullable();
            $table->boolean('published')->default(true);
            $table->string("seo_title")->nullable();
            $table->string("seo_description")->nullable();

            $table->string('barcode')->nullable();
            $table->integer('bitrix_id')->nullable();
            $table->string('source_loader')->nullable();
            $table->integer('in_stock')->default(0);
            $table->float('weight_net')->default(0);
            $table->float('weight_gross')->default(0);
            $table->float('length')->default(0);
            $table->float('width')->default(0);
            $table->float('height')->default(0);
            $table->integer('number_of_seats')->default(0);
            $table->float('volume')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
