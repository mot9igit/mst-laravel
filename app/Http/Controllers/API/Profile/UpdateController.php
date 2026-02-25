<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UpdateController extends BaseController
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function __invoke(UpdateRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        // dd($request);
        $data = $request->validated();
        if ($data["image"]) {
            try{
                $user->addMediaFromRequest('image')->toMediaCollection('image');
            }catch (FileDoesNotExist $exception){
                response()->json(["message" => "error", "data" => $exception]);
            }catch (FileIsTooBig $exception){
                response()->json(["message" => "error", "data" => $exception]);
            }
        }
        unset($data["image"]);
        $response = $this->service->update($data);
        return response()->json(["message" => "success", "data" => $response]);
    }
}
