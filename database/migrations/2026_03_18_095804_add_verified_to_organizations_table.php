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
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name');
            $table->decimal('balance')->nullable()->after('address');
            $table->unsignedSmallInteger("store")->default(0)->after('active');
            $table->unsignedSmallInteger("warehouse")->default(0)->after('store');
            $table->unsignedSmallInteger("vendor")->default(0)->after('warehouse');
            $table->unsignedSmallInteger("verified")->default(0)->after('vendor');


            $table->index('code', 'organization_code_idx');
            $table->index('balance', 'organization_balance_idx');
            $table->index('store', 'organization_store_idx');
            $table->index('warehouse', 'organization_warehouse_idx');
            $table->index('vendor', 'organization_vendor_idx');
            $table->index('verified', 'organization_verified_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropIndex('organization_code_idx');
            $table->dropIndex('organization_balance_idx');
            $table->dropIndex('organization_store_idx');
            $table->dropIndex('organization_warehouse_idx');
            $table->dropIndex('organization_vendor_idx');
            $table->dropIndex('organization_verified_idx');

            $table->dropColumn('code');
            $table->dropColumn('balance');
            $table->dropColumn('store');
            $table->dropColumn('warehouse');
            $table->dropColumn('vendor');
            $table->dropColumn('verified');
        });
    }
};
