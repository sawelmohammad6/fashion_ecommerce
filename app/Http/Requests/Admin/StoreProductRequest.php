<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($this->route('product'))],
            'description' => ['nullable', 'string'],
            'fabric' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
            'print' => ['nullable', 'string', 'max:255'],
            'size' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'featured' => ['boolean'],
            'status' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'category',
            'name' => 'product name',
            'slug' => 'slug',
            'price' => 'price',
            'discount_price' => 'discount price',
            'stock' => 'stock',
            'image' => 'thumbnail image',
            'gallery_images.*' => 'gallery image',
        ];
    }
}
