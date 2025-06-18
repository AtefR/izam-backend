<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrderAction;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function store(
        OrderRequest $request,
        CreateOrderAction $action,
    )
    {
        $order = $action->handle($request->validated());

        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
