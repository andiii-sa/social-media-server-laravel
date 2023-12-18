<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Support\Facades\Validator;

class BlogCategoryController extends Controller
{
    private $rules = [
        'name' => ['required', 'string'],
    ];

    public function create(Request $request)
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

    public function update(Request $request, $id)
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

    public function getAll(Request $request)
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

    public function get(Request $request)
    {
        try {
            $name = $request->input('name');
            $offset = $request->input('offset') ?? 0;
            $limit = $request->input('limit') ?? 5;

            $category = BlogCategory::query()->offset(((int)$offset) * ((int)$limit))->limit((int)$limit);

            if ($name) {
                $category->where('name', 'like', '%' . $name . '%');
            }

            return ResponseFormatter::pagination($category->get(), 'Success', $offset, $limit);
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

    public function delete($id)
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

    public function deletePermanent($id)
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

    public function restore($id)
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
}