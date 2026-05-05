<?php
namespace App\Repositories;

use App\Models\ContactPerson;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ContactPersonRepository
{
    /**
     * Получение списка контактных лиц
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function get(array $data): LengthAwarePaginator{
       return ContactPerson::with('organization')->paginate();
    }

    /**
     * Удаление контактного лица
     *
     * @param int $contact_person_id
     * @return string
     */
    public function delete(int $contact_person_id){
        $contactPerson = ContactPerson::findOrFail($contact_person_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $contactPerson->forceDelete();
            }else{
                $response = $contactPerson->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание контактного лица в БД
     *
     * @param array $validated
     * @return ContactPerson|bool
     */
    public function create(array $validated): ContactPerson | bool
    {
        DB::beginTransaction();
        try {
            $contactPerson = ContactPerson::create($validated);
            DB::commit();
            return $contactPerson;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания контактного лица: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление контактного лица в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     * @throws Throwable
     */
    public function update(int $id, array $validated): mixed
    {
        $contactPerson = ContactPerson::findOrFail($id);
        DB::beginTransaction();
        try {
            $updatedContactPerson = $contactPerson->update($validated);
            DB::commit();
            return $updatedContactPerson;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении контактного лица: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении контактного лица: ' . $e->getMessage());
            return false;
        }
    }
}
