<?php

namespace App\Http\Controllers\API\Files;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Files\UploadRequest;
use App\Services\Tools\FileUploaderService;
use Illuminate\Http\Request;

class UploadController extends Controller
{

    public function __construct(
        private readonly FileUploaderService $service
    ){}

    /**
     * Handle the incoming request.
     */
    public function __invoke(UploadRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->handle($validated, $request);
        return $response;
    }
}
