<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'max:1000'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'int']
        ];
    }
}
