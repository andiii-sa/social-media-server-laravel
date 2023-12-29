<?php

namespace App\Exports;

use App\Models\PresenceEmployee;
use App\Models\PresenceScheduleEmployee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PresenceEmployeeExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'day_name',
            'employee_name',
            'employee_email',
            'clock_in',
            'clock_out',
        ];
    }

    public function map($preflight): array
    {
        return [
            $preflight->dayName,
            $preflight->employee->name,
            $preflight->employee->email,
            $preflight->clockIn,
            $preflight->clockOut,
        ];
    }

    public function collection()
    {
        return PresenceEmployee::with(['employee', 'day'])->get();
    }

    public function title(): string
    {
        return 'data_presence_employee';
    }
}
