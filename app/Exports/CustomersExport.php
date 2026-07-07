<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Username',
            'Email',
            'Phone',
            'Gender',
            'Country',
            'City',
            'Status',
            'Verified',
            'Registered',
            'Total Orders',
            'Total Spent',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->name,
            $customer->username,
            $customer->email,
            $customer->phone ?? '',
            $customer->gender ?? '',
            $customer->country ?? '',
            $customer->city ?? '',
            ucfirst($customer->status),
            $customer->email_verified_at ? 'Yes' : 'No',
            $customer->created_at->format('Y-m-d'),
            $customer->orders_count ?? 0,
            number_format($customer->spent ?? 0, 2),
        ];
    }
}
