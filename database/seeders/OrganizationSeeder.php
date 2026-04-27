<?php

namespace Database\Seeders;

use App\Models\BankRequisite;
use App\Models\Organization;
use App\Models\Requisite;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::factory()->create([
            "name" => "ИП Петропавловский Артем Витальевич",
            "description" => "test",
            "active" => 1,
            "verified" => 1,
            "store" => 1,
            "vendor" => 1,
            "warehouse" => 1
        ]);

        $requisite = Requisite::factory()->create([
            "name" => "ИП Петропавловский Артем Витальевич",
            "ogrn" => "316595800069435",
            "inn" => '592005586263',
            "kpp" => "",
            "ur_address" => "г Пермь, ул Космонавта Беляева, д 19, офис 402",
            "fact_address" => "г Пермь, ул Космонавта Беляева, д 19, офис 402",
            "description" => "test"
        ]);

        $organization->requisites()->attach([$requisite->id]);

        $bankRequisite = BankRequisite::factory()->create([
            "name" => "ООО \"Банк Точка\" г Москва",
            "number" => "40802810420000150536",
            "knumber" => '30101810745374525104',
            "bik" => "044525104",
            "requisite_id" => $requisite->id,
            "description" => "test"
        ]);

        $store = Store::factory()->create([
            "name" => "Dart",
            "name_short" => "Dart",
            "address" => "г Пермь, ул Космонавта Беляева, д 19, офис 402",
            "coordinates" => '57.971403, 56.177009',
            "city_id" => 1,
            "active" => 1,
            "integration_type" => 1,
            "marketplace" => 1,
            "opt_marketplace" => 1,
            "check_remains" => 1,
            "check_docs" => 1,
            "description" => "test"
        ]);
        $attr = [
            "dropshipping" => 1,
            "description" => "test"
        ];
        $organization->stores()->attach($store->id, $attr);
    }
}
