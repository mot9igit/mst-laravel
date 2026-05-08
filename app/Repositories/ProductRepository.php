<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    public function get(array $data): LengthAwarePaginator
    {
        $perpage = $data['perpage'] ?? 12;
        $filter = $data['filter'] ?? '';
        $sort = $data['sort'] ?? [];

        $sortBy = 'id';
        $sortDir = 'desc';
        if (count($sort) > 0) {
            foreach ($sort as $key => $value) {
                $sortBy = $key;
                $sortDir = $value['dir'];
            }
        }

        $allowedSorts = ['id', 'title', 'price', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        $query = Product::with(['category', 'vendor']);

        if ($filter != '') {
            $query->where(function ($q) use ($filter) {
                $q->where('title', 'like', '%' . $filter . '%')
                    ->orWhere('article', 'like', '%' . $filter . '%')
                    ->orWhere('barcode', 'like', '%' . $filter . '%');
            });
        }

        $products = $query->orderBy($sortBy, $sortDir)
            ->paginate($perpage);

        return $products;
    }

    public function create(array $validated): Product | bool
    {
        DB::beginTransaction();
        try {
            $product = Product::create($validated);
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания товара: ' . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $validated): mixed
    {
        $product = Product::findOrFail($id);
        DB::beginTransaction();
        try {
            $product->update($validated);
            DB::commit();
            return $product;
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении товара: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении товара: ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id)
    {
        $product = Product::findOrFail($id);
        DB::beginTransaction();
        try {
            $response = $product->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }
}
