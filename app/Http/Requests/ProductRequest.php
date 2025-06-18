<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'price' => ['required'],
            'stock' => ['required', 'integer'],
            'category_id' => ['required', 'exists:categories'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
