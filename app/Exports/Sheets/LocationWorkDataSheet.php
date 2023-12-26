<?php

namespace App\Exports\Sheets;

use App\Models\PresenceLocationWork;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class LocationWorkDataSheet implements FromQuery, WithMapping, WithHeadings, WithTitle
{

    public function headings(): array
    {
        return [
            'id',
            'name',
            'clockIn',
            'clockOut',
        ];
    }

    public function map($preflight): array
    {
        return [
            $preflight->id,
            $preflight->name,
            $preflight->clockIn,
            $preflight->clockOut,
        ];
    }

    public function query()
    {
        return PresenceLocationWork::query();
    }

    public function title(): string
    {
        return 'data_location_work';
    }
}
