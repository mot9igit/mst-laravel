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
        Schema::create('stores_doc', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->unsigned();
            $table->string('number')->nullable();
            $table->string('base_guid')->nullable();
            $table->string('guid')->default('');
            $table->datetime('date')->nullable();
            $table->string('description')->nullable();
            $table->json("properties")->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();

            $table->index(['store_id', 'guid'], 'store_doc_store_id_guid_idx');

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_docs');
    }
};
