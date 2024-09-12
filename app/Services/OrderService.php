<?php


namespace App\Services;


use App\Repositories\OrderRepositoryInterface;

class OrderService
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders() {
        return $this->orderRepository->all();
    }

    // Business logic to find a user by ID
    public function getUserById($id)
    {
        return $this->orderRepository->find($id);
    }

    // Business logic to create a new user
    public function createOrder(array $data)
    {
        // Add additional business logic, such as validation, here
        return $this->orderRepository->create($data);
    }

    // Business logic to update a user
    public function updateUser($id, array $data)
    {
        // Additional business logic, such as checking permissions
        return $this->orderRepository->update($id, $data);
    }

    // Business logic to delete a user
    public function deleteUser($id)
    {
        return $this->orderRepository->delete($id);
    }
}
