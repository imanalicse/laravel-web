<?php


namespace App\Services;


use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(productRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts() {
        return $this->productRepository->all();
    }

    public function getPaginatedProducts($perPage)
    {
        return $this->productRepository->paginate($perPage);
    }
}
