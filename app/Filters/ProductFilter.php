<?php

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

readonly class ProductFilter
{
    public function __construct(protected Request $request) {}

    public function apply(Builder $query): Builder
    {
        return $query
            ->when($this->request->name, fn($q) => $q->where('name', 'like', "%{$this->request->name}%"))
            ->when($this->request->categories, fn($q) => $q->whereIn('category_id', explode(',', $this->request->categories)))
            ->when($this->request->min_price, fn($q) => $q->where('price', '>=', $this->request->min_price))
            ->when($this->request->max_price, fn($q) => $q->where('price', '<=', $this->request->max_price));
    }
}
