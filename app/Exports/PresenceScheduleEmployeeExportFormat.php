<?php

namespace App\Exports;

use App\Exports\Sheets\EmployeeDataSheet;
use App\Exports\Sheets\LocationWorkDataSheet;
use App\Exports\Sheets\PresenceScheduleEmployeeDataSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PresenceScheduleEmployeeExportFormat implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new PresenceScheduleEmployeeDataSheet();
        $sheets[] = new LocationWorkDataSheet();
        $sheets[] = new EmployeeDataSheet();

        return $sheets;
    }
}
