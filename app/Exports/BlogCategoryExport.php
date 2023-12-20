<?php

namespace App\Exports;

use App\Models\BlogCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BlogCategoryExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'id',
            'name',
        ];
    }

    public function collection()
    {
        return BlogCategory::query()->select('id', 'name')->get();
    }

    public function title(): string
    {
        return 'blog_category';
    }
}
