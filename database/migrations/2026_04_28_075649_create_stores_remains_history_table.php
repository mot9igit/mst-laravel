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
        Schema::create('stores_remains_history', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->useCurrent();
            $table->string('name');
            $table->string('article');
            $table->bigInteger('remain_id')->unsigned();
            $table->bigInteger('remains')->default(0);
            $table->bigInteger('reserved')->default(0);
            $table->bigInteger('available')->default(0);
            $table->float('price')->default(0);
            $table->timestamps();

            $table->index('remain_id', 'stores_remains_history_remain_idx');

            $table->foreign('remain_id')->references('id')->on('stores_remains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores_remains_history');
    }
};
