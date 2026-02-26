<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\API\User\UpdateRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, $user){
        $validated = $request->validated();
        $user = User::findOrFail($user);
        DB::beginTransaction();
        try {
            $user->update($validated);
            DB::commit();
            return response()->json(['user' => $user]);
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении пользователя: ' . $e->getMessage());

            return response()->json([
                'error' => 'Ошибка базы данных',
                'details' => 'Проверьте корректность данных'
            ], 422);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении пользователя: ' . $e->getMessage());
            return response()->json([
                'error' => 'Не удалось обновить пользователя',
                'details' => 'Произошла ошибка на сервере'
            ], 500);
        }
    }
}
