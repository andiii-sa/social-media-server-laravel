<?php

namespace App\Exports\Sheets;

use App\Models\Blog;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BlogDataSheet implements FromQuery, WithMapping, WithHeadings, WithTitle
{

    public function headings(): array
    {
        return [
            'id',
            'author',
            'blog_category',
            'title',
            'body',
        ];
    }

    public function map($preflight): array
    {
        return [
            $preflight->id,
            $preflight->author->name,
            $preflight->category->name,
            $preflight->title,
            $preflight->body,
        ];
    }

    public function query()
    {
        return Blog::with(['category', 'author']);
    }

    public function title(): string
    {
        return 'blog';
    }
}
