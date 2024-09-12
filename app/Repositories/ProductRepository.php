<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::all();
    }

    public function paginate($perPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
      return Product::orderByDesc('id')->paginate($perPage);
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $item = Product::find($id);
        return $item ? $item->update($data) : null;
    }

    public function delete($id)
    {
        $item = Product::find($id);
        return $item ? $item->delete() : null;
    }
}
