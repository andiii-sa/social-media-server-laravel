<?php

namespace App\Exports\Sheets;

use App\Models\Blog;
use App\Models\PresenceScheduleEmployee;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PresenceScheduleEmployeeDataSheet implements FromQuery, WithMapping, WithHeadings, WithTitle
{

    public function headings(): array
    {
        return [
            'id',
            'dayId',
            'employeeId',
            'locationWorkId',
        ];
    }

    public function map($preflight): array
    {
        return [
            $preflight->id,
            $preflight->dayId,
            $preflight->employeeId,
            $preflight->locationWorkId,
        ];
    }

    public function query()
    {
        return PresenceScheduleEmployee::query();
    }

    public function title(): string
    {
        return 'data_schedule_employee';
    }
}
