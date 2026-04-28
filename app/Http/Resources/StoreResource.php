<?php

namespace App\Http\Resources;

use App\Enums\StoreIntegrationType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_short' => $this->name_short,
            "image" => $this->image,
            "thumbnail" => $this->thumbnail,
            "thumb_url" => $this->thumb_url,
            "image_url" => $this->image_url,
            "address" => $this->address,
            "description" => $this->description,
            "coordinates" => $this->coordinates,
            "city_id" => $this->city_id,
            "city" => $this->city,
            "active" => $this->active,
            "integration_type" => [
                'name' => $this->integration_type->label(),
                'code' => $this->integration_type
            ],
            "marketplace" => $this->marketplace,
            "opt_marketplace" => $this->opt_marketplace,
            "version" => $this->version,
            "yml_file" => $this->yml_file,
            "check_remains" => $this->check_remains,
            "check_docs" => $this->check_docs,
            "date_api_ping" => $this->date_api_ping,
            "date_remains_update" => $this->date_remains_update,
            "date_docs_update" => $this->date_docs_update,
            "properties" => $this->properties
        ];
    }
}
