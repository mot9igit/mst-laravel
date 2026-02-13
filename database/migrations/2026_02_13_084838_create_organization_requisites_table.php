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
        Schema::create('organization_requisites', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('organization_id')->unsigned();
            $table->bigInteger('requisite_id')->unsigned();

            $table->index('organization_id', 'organization_requisite_organization_idx');
            $table->index('requisite_id', 'organization_requisite_requisite_idx');

            $table->foreign('organization_id', 'organization_requisite_organization_fk')->on('organizations')->references('id');
            $table->foreign('requisite_id', 'organization_requisite_requisite_fk')->on('requisites')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_requisites');
    }
};
