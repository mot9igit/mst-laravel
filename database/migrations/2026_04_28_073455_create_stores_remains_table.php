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
        Schema::create('stores_remains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('article');
            $table->string('guid');
            $table->bigInteger('store_id')->unsigned();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('catalog_id')->unsigned()->nullable();
            $table->bigInteger('vendor_id')->unsigned()->nullable();
            $table->integer('status')->unsigned();
            $table->string('catalog_guid')->nullable();
            $table->string('barcode')->nullable();
            $table->bigInteger('remains')->default(0);
            $table->bigInteger('reserved')->default(0);
            $table->bigInteger('available')->default(0);
            $table->float('price')->default(0);
            $table->string('description')->nullable();
            $table->string('tags')->nullable();
            $table->timestamps();

            $table->index('product_id', 'stores_remains_product_idx');
            $table->index('store_id', 'stores_remains_store_idx');
            $table->index('catalog_id', 'stores_remains_catalog_idx');
            $table->index('vendor_id', 'stores_remains_vendor_idx');

            // Связь с категориями
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->foreign('catalog_id')->references('id')->on('stores_remains_catalogs')->nullOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->nullOnDelete();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores_remains');
    }
};
