<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttributeValueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $attributeId = $this->route('attribute')?->id ?? $this->input('attribute_id');
        $valueId = $this->route('attribute_value')?->id;

        return [
            'value' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('attribute_values', 'slug')->where(fn ($q) => $q->where('attribute_id', $attributeId))->ignore($valueId)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
