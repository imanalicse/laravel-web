<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function all()
    {
        return Order::all();
    }

    public function find($id)
    {
        return Order::find($id);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update($id, array $data)
    {
        $item = Order::find($id);
        return $item ? $item->update($data) : null;
    }

    public function delete($id)
    {
        $item = Order::find($id);
        return $item ? $item->delete() : null;
    }
}