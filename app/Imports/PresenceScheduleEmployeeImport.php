<?php

namespace App\Imports;

use App\Imports\Sheets\PresenceScheduleEmployeeSheetImport;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PresenceScheduleEmployeeImport implements WithMultipleSheets, SkipsUnknownSheets
{
    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        return [
            'data_schedule_employee' => new PresenceScheduleEmployeeSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        return "Sheet {$sheetName} was skipped";
    }
}
