<?php

/**
 * Используется laravel-dadata
 * https://github.com/movemoveapp/laravel-dadata
 */

namespace App\Services\Dadata;

use MoveMoveIo\DaData\Enums\BranchType;
use MoveMoveIo\DaData\Enums\CompanyType;
use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use MoveMoveIo\DaData\Facades\DaDataCompany;

class Service
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function getCompaniesByInn(string $inn): \MoveMoveIo\DaData\DaDataCompany | array
    {
        if($inn) {
            $dadata = DaDataCompany::id($inn, 3, null, BranchType::MAIN, CompanyType::LEGAL);
            if (!$dadata) {
                $dadata = DaDataCompany::id($inn, 3, null, BranchType::MAIN, CompanyType::INDIVIDUAL);
            }
            return $this->prepareData($dadata);
        }
        return [];
    }

    public function getAddress(string $query){
        if($query) {
            $dadata = DaDataAddress::prompt($query, 5, Language::RU);
            return $this->prepareData($dadata);
        }
        return [];
    }

    public function prepareData(array $data): array{
        $items = [];
        if($data['suggestions']){
            foreach($data['suggestions'] as $suggestion){
                $items[] = $suggestion;
            }
        }
        return $items;
    }

}
