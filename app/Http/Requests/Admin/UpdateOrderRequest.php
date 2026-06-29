<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:pending,confirmed,processing,shipped,delivered,cancelled,returned'],
            'payment_status' => ['required', 'string', 'in:pending,paid,failed,refunded'],
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => 'order status',
            'payment_status' => 'payment status',
        ];
    }
}
