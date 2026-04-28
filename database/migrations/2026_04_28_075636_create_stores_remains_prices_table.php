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
        Schema::create('stores_remains_prices', function (Blueprint $table) {
            $table->id();
            $table->string('guid');
            $table->string('name');
            $table->bigInteger('remain_id')->unsigned();
            $table->float('price')->default(0);
            $table->unsignedSmallInteger("active")->default(1);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index('guid', 'stores_remains_prices_guid_idx');
            $table->index('remain_id', 'stores_remains_prices_remain_idx');
            $table->index('active', 'stores_remains_prices_active_idx');

            $table->foreign('remain_id')->references('id')->on('stores_remains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores_remains_prices');
    }
};
