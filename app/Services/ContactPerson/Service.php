<?php

namespace App\Services\ContactPerson;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use App\Repositories\ContactPersonRepository;

class Service
{
    public function __construct(
        private readonly ContactPersonRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление контактного лица
     *
     * @param int $contact_person_id
     * @return string
     */
    public function delete(int $contact_person_id){
        return $this->repository->delete($contact_person_id);
    }

    /**
     * Создание контактного лица
     *
     * @param $validated
     * @return JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $contact_person = $this->repository->create($validated);

        return response()->json([
            'message' => 'Контактное лицо успешно создано',
            'contactPerson' => $contact_person
        ], 201);
    }

    /**
     * Обновление контактного лица
     *
     * @param int $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $id, array $validated): JsonResponse
    {
        $city = $this->repository->update($id, $validated);
        return response()->json([
            'message' => 'Контактное лицо успешно обновлено',
            'city' => $city
        ], 201);
    }
}
