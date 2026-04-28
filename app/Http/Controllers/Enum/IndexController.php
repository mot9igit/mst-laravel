<?php

namespace App\Http\Controllers\Enum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    public function __invoke(string $enum): \Illuminate\Http\JsonResponse
    {
        // Безопасное формирование имени класса
        $className = 'App\\Enums\\' . $enum;

        if (!class_exists($className)) {
            return Response::json(['error' => 'Объект не найден'], 404);
        }

        if (!is_subclass_of($className, \BackedEnum::class)) {
            return Response::json(['error' => 'Объект не найден'], 400);
        }

        $cases = $className::cases();
        $data = array_map(function ($case) {
            return [
                'name' => $case->label(),
                'code' => $case->value
            ];
        }, $cases);

        return Response::json(["data" => $data]);
    }
}
