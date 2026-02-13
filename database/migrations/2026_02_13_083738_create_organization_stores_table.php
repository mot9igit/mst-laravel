<?php

use App\Models\Organization;
use App\Models\Store;
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
        Schema::create('organization_stores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->unsigned();
            $table->bigInteger('store_id')->unsigned();

            $table->index('organization_id', 'organization_store_organization_idx');
            $table->index('store_id', 'organization_store_store_idx');

            $table->foreign('organization_id', 'organization_store_organization_fk')->on('organizations')->references('id');
            $table->foreign('store_id', 'organization_store_store_fk')->on('stores')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_stores');
    }
};
