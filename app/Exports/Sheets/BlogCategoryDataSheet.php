<?php

namespace App\Exports\Sheets;

use App\Models\BlogCategory;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BlogCategoryDataSheet implements FromQuery, WithHeadings, WithTitle
{

    public function headings(): array
    {
        return [
            'id',
            'name',
        ];
    }

    public function query()
    {
        return BlogCategory::query()->select('id', 'name');
    }

    public function title(): string
    {
        return 'blog_category';
    }
}
