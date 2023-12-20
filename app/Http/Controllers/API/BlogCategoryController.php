<?php

namespace App\Http\Controllers\API;

use App\Exports\BlogCategoryExport;
use App\Exports\BlogCategoryExportFormat;
use App\Exports\BlogExport;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BlogCategoryController extends Controller
{
    private $rules = [
        'name' => ['required', 'string'],
    ];

    public function created(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $findCategory = BlogCategory::where('name', strtolower($request->name))->first();
            if ($findCategory) {
                return ResponseFormatter::error(null, 'Data already exists', 400);
            }

            $category = BlogCategory::create([
                'name' => $request->name,
            ]);

            return ResponseFormatter::success($category, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function updated(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $category = BlogCategory::find($id);
            if (!$category) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $findCategory = BlogCategory::where('name', strtolower($request->name))->first();
            if ($category->name !== $request->name && $findCategory) {
                return ResponseFormatter::error(null, 'Data already exists', 400);
            }

            $category->fill($request->all());
            $category->save();

            return ResponseFormatter::success($category, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function showAll(Request $request)
    {
        try {
            $name = $request->input('name');
            $showDeleted = $request->input('showDeleted');
            $category = BlogCategory::query();

            if ($name) {
                $category->where('name', 'like', '%' . $name . '%');
            }
            if ($showDeleted) {
                $category->withTrashed();
            }

            return ResponseFormatter::success($category->get(), 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $name = $request->input('name');
            $offset = $request->input('offset') ?? 0;
            $limit = $request->input('limit') ?? 5;
            $showDeleted = $request->input('showDeleted');

            $category = BlogCategory::query();

            if ($name) {
                $category->where('name', 'like', '%' . $name . '%');
            }
            if ($showDeleted) {
                $category->withTrashed();
            }

            $count = $category->get()->count();
            $data = $category->offset(((int)$offset) * ((int)$limit))->limit((int)$limit);

            return ResponseFormatter::pagination($data->get(), 'Success', $count, $offset, $limit);
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function detail($id)
    {
        try {
            $category = BlogCategory::find($id);
            if (!$category) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            return ResponseFormatter::success($category, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function deleted($id)
    {
        try {
            $category = BlogCategory::find($id);
            if (!$category) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $category->delete();

            return ResponseFormatter::success($category, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function forceDeleted($id)
    {
        try {
            $category = BlogCategory::withTrashed()->find($id);
            if (!$category) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $category->forceDelete();

            return ResponseFormatter::success($category, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function restored($id)
    {
        try {
            $category = BlogCategory::withTrashed()->find($id);
            if (!$category) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $category->restore();

            return ResponseFormatter::success($category, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function fileExportFormat()
    {
        try {
            return Excel::download(new BlogCategoryExportFormat, 'blog-category-format.xlsx');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function fileExportData()
    {
        try {
            return Excel::download(new BlogCategoryExport, 'blog-category.xlsx');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function fileExportDataMS()
    {
        try {
            return Excel::download(new BlogExport, 'blog-category-ms.xlsx');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }
}
