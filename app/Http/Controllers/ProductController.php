<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Cache::remember('products:' . md5(json_encode($request->all())), 60, function () use ($request) {
            $filter = new ProductFilter($request);

            return $filter->apply(Product::query())
                ->with('category')
                ->paginate($request->get('page_size') ?? 10);
        });

        return ProductResource::collection($products)
            ->additional([
                'meta' => [
                    'max_price' => Product::max('price'),
                ]
            ]);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
