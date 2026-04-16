<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    public function getAll($request): LengthAwarePaginator
    {
        $perPage = $request->integer('itemsPerPage', 10);

        return Product::query()
            ->select('*')
            ->search($request->search)
            ->sort($request->sortKey, $request->sortOrder)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Product
    {
        return Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
        ]);
    }

    public function update(string $id, array $data): Product
    {
        $product = Product::find($id);
        if (!$product) {
            throw new NotFoundHttpException('Product not found.');
        }

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
        ]);

        return $product;
    }

    public function delete(string $id): void
    {
        $product = Product::find($id);
        if (!$product) {
            throw new NotFoundHttpException('Product not found.');
        }

        $product->delete();
    }
}
