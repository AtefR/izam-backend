<?php

namespace App\Actions;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateOrderAction
{
    /**
     * @throws \Throwable
     */
    public function handle(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $items = Arr::get($data, 'items');
            $productIds = Arr::pluck($items, 'id');

            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $subtotal = 0;

            foreach ($items as $index => $item) {
                $product = $products[$item['id']] ?? null;

                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        "items.$index.quantity" => ["$product->name is out of stock."],
                    ]);
                }

                $subtotal += $product->price * $item['quantity'];
            }

            $shipping = 15;
            $tax = 12.5;
            $total = $subtotal + $shipping + $tax;

            $order = Order::create([
                'status' => OrderStatus::COMPLETED,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'user_id' => Auth::id(),
            ]);

            foreach ($items as $item) {
                $product = $products[$item['id']];

                OrderItem::create([
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                    'total'      => $product->price * $item['quantity'],
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return $order;
        });
    }
}
