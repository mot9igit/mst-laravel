<?php

namespace App\Http\Controllers\API\Integration\ApiKey;

class GenerateController extends BaseController
{
    public function __invoke()
    {
        $data = $this->service->generate();

        return response()->json([
            'message' => 'Ключ сгенерирован',
            'key' => $data
        ], 201);
    }
}
