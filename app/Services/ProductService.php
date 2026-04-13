<?php


namespace App\Services;


use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): \Illuminate\Database\Eloquent\Collection {
        return $this->productRepository->all();
    }

    public function getPaginatedProducts(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->productRepository->paginate();
    }
}
