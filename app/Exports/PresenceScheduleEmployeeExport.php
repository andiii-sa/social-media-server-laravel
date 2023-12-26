<?php

namespace App\Exports;

use App\Models\PresenceScheduleEmployee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PresenceScheduleEmployeeExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'id',
            'dayId',
            'day_name',
            'employeeId',
            'employee_name',
            'employee_email',
            'locationWorkId',
            'location_work_name',
        ];
    }

    public function map($preflight): array
    {
        return [
            $preflight->id,
            $preflight->dayId,
            $preflight->day->name,
            $preflight->employeeId,
            $preflight->employee->name,
            $preflight->employee->email,
            $preflight->locationWorkId,
            $preflight->location_work->name,
        ];
    }

    public function collection()
    {
        return PresenceScheduleEmployee::with(['employee', 'location_work', 'day'])->get();
    }

    public function title(): string
    {
        return 'data_schedule_employee_all';
    }
}
