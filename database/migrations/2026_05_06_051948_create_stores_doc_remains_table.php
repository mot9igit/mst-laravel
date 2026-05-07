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
        Schema::create('stores_doc_remain', function (Blueprint $table) {
            $table->id();
            $table->string('guid');
            $table->bigInteger('doc_id')->unsigned();
            $table->bigInteger('remain_id')->unsigned();
            //1 or 2 (продажа, возврат)
            $table->unsignedInteger('type')->default(1);
            $table->string('article')->nullable();
            $table->bigInteger('count')->default(0);
            $table->float('price')->default(0);
            $table->string('description')->nullable();
            $table->json("properties")->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();

            $table->index(['doc_id', 'remain_id'], 'store_doc_remain_doc_id_guid_idx');

            $table->foreign('doc_id')->references('id')->on('stores_doc')->onDelete('cascade');
            $table->foreign('remain_id')->references('id')->on('stores_remains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_doc_remains');
    }
};
