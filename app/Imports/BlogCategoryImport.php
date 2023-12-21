<?php

namespace App\Imports;

use App\Models\BlogCategory;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BlogCategoryImport implements WithMultipleSheets, SkipsUnknownSheets
{
    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        return [
            'data_category' => new FirstSheetImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        return "Sheet {$sheetName} was skipped";
    }
}

class FirstSheetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new BlogCategory([
            'name'     => $row['name'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
}
