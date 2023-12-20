<?php

namespace App\Exports;

use App\Exports\Sheets\BlogCategoryDataSheet;
use App\Exports\Sheets\BlogDataSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BlogExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new BlogDataSheet();
        $sheets[] = new BlogCategoryDataSheet();

        return $sheets;
    }
}
