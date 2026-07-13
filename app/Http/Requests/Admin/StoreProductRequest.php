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
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'full_description' => ['nullable', 'string'],
            'fabric' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
            'print' => ['nullable', 'string', 'max:255'],
            'size' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'buying_price' => ['nullable', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', function ($attr, $value, $fail) {
                if ($this->input('discount_type') === 'fixed' && $value >= $this->input('price')) {
                    $fail('The discount price must be less than the regular price.');
                }
                if ($this->input('discount_type') === 'percentage' && $value > 100) {
                    $fail('The percentage discount cannot exceed 100%.');
                }
            }],
            'discount_type' => ['nullable', 'string', 'in:fixed,percentage'],
            'stock' => ['required', 'integer', 'min:0'],
            'low_stock_alert_quantity' => ['nullable', 'integer', 'min:1'],
            'sku' => ['nullable', 'string', 'max:255'],
            'barcode' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'featured' => ['boolean'],
            'status' => ['boolean'],
            'pre_order' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'attribute_values' => ['nullable', 'array'],
            'attribute_values.*' => ['integer', 'exists:attribute_values,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'category',
            'name' => 'product name',
            'slug' => 'slug',
            'brand' => 'brand',
            'price' => 'regular price',
            'buying_price' => 'buying price',
            'discount_price' => 'discount price',
            'discount_type' => 'discount type',
            'stock' => 'stock',
            'sku' => 'SKU',
            'barcode' => 'barcode',
            'image' => 'thumbnail image',
            'gallery_images.*' => 'gallery image',
            'video_url' => 'video URL',
            'meta_title' => 'meta title',
            'meta_description' => 'meta description',
            'meta_keywords' => 'meta keywords',
        ];
    }
}
