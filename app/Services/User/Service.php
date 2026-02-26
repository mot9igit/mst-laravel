<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class Service
{
    public $user;
    public $user_id;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->user_id = Auth::id();
    }

    public function get(){

    }

    /**
     * Создание пользователя
     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($request){
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'fullname' => $validated['fullname'],
                'active' => $validated['active'],
                'sudo' => $validated['sudo'],
                'password' => Hash::make($validated['password']),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Пользователь успешно создан',
                'user' => $user
            ], 201);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания пользователя: ' . $e->getMessage());
            return response()->json([
                'error' => 'Не удалось создать пользователя',
                'details' => 'Произошла ошибка на сервере'
            ], 500);
        }
    }

    /**
     * Обновление профиля
     *
     * @param $data
     * @return bool|\Exception
     */
    public function update($data){
        $user = Auth::user();
        $user_id = Auth::id();
        try{
            DB::beginTransaction();
//            if(isset($data['images'])){
//                $images = $data['images'];
//                $name = md5(Carbon::now() . '_' . $images[0]->getClientOriginalName()) . '.' . $images[0]->getClientOriginalExtension();
//                $path = 'images/users/' . $user_id . '/avatars';
//                $manager = ImageManager::gd();
//                $image = $manager->read($images[0])
//                    ->cover(300, 300);
//                $imagedata = (string) $image->toJpeg();
//                Storage::disk('public')->put($path.'/'.$name, $imagedata);
//                $data['avatar'] = '/storage/'.$path.'/'.$name;
//                unset($data['images']);
//            }
            $response = $user->update($data);
            DB::commit();
            return $response;
        }catch(\Exception $exception){
            DB::rollBack();
            return $exception;
        }
    }
}
