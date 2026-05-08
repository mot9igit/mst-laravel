<?php

namespace App\Http\Requests\API\StoreDoc;

use App\Http\Requests\Base\BaseQueryRequest;

class IndexRequest extends BaseQueryRequest {
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'store_id' => 'nullable|integer',
            'remain_id' => 'nullable|integer',
        ]);
    }
}
