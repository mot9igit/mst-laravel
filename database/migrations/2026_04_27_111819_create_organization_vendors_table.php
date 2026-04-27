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
        Schema::create('organization_vendors', function (Blueprint $table) {

            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('vendor_id');
            $table->string('description')->nullable();

            // Внешние ключи
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            // Составной первичный ключ
            $table->primary(['organization_id', 'vendor_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_vendors');
    }
};
