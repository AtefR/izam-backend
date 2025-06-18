<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'price' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'quantity' => ['required', 'integer'],
            'order_id' => ['required', 'exists:orders'],
            'product_id' => ['required', 'exists:products'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
