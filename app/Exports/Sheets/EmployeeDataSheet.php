<?php

namespace App\Exports\Sheets;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmployeeDataSheet implements FromQuery, WithMapping, WithHeadings, WithTitle
{

    public function headings(): array
    {
        return [
            'id',
            'username',
            'name',
            'email',
        ];
    }

    public function map($preflight): array
    {
        return [
            $preflight->id,
            $preflight->username,
            $preflight->name,
            $preflight->email,
        ];
    }

    public function query()
    {
        return User::query();
    }

    public function title(): string
    {
        return 'data_employee';
    }
}
