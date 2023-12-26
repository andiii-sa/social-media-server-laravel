<?php

namespace App\Imports\Sheets;

use App\Models\PresenceScheduleEmployee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class PresenceScheduleEmployeeSheetImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new PresenceScheduleEmployee([
            'id'     => $row['id'],
            'dayId'     => $row['dayId'],
            'employeeId'     => $row['employeeId'],
            'locationWorkId'     => $row['locationWorkId'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
}
