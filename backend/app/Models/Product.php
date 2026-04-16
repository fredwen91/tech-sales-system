<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('price', 'like', "%{$search}%")
                ->orWhere('stock', 'like', "%{$search}%");
        });
    }

    public function scopeSort(Builder $query, ?string $sortKey, ?string $sortOrder): Builder
    {
        $allowedSorts = [
            'name',
            'description',
            'price',
            'stock',
            'created_at',
            'updated_at',
        ];

        if (!in_array($sortKey, $allowedSorts)) {
            return $query->orderByDesc('created_at');
        }

        $sortOrder = strtolower($sortOrder) === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortKey, $sortOrder);
    }
}
