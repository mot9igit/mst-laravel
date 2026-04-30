<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stores_remains_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guid');
            $table->string('parent_guid')->nullable();
            $table->string('base_guid')->nullable();
            $table->string('name_alt')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->bigInteger('store_id')->unsigned();
            $table->string('description')->nullable();
            $table->unsignedSmallInteger("active")->default(1);
            $table->unsignedSmallInteger("published")->default(1);
            $table->json("properties")->default(new Expression('(JSON_ARRAY())'));
            $table->softDeletes();
            $table->timestamps();

            $table->index('parent_id', 'stores_remains_catalogs_parent_idx');
            $table->index('store_id', 'stores_remains_catalogs_store_idx');

            // Связь с категориями
            $table->foreign('parent_id')->references('id')->on('stores_remains_catalogs')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores_remains_catalogs');
    }
};
