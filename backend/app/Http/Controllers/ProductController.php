<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(IndexRequest $request): JsonResponse
    {
        return response()->json(
            $this->productService->getAll($request)
        );
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product
        ], 201);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productService->update($id, $request->validated());

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product
        ]);
    }

    public function destroy(string $id)
    {
        $this->productService->delete($id);

        return response()->json([
            'message' => 'Product deleted successfully.'
        ]);
    }
}
