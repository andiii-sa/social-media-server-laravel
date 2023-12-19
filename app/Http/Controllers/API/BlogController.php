<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function created(Request $request)
    {
        $rules = [
            'authorId' => 'required|exists:users,id|numeric',
            'blogCategoryId' => 'required|exists:blog_category,id|numeric',
            'title' => 'required|string',
            'image' => 'required|image',
            'body' => 'required|string',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $findCategory = Blog::where('title', strtolower($request->title))->first();
            if ($findCategory) {
                return ResponseFormatter::error(null, 'Title already exists', 400);
            }
            $data = $request->all();
            $data['image'] = $request->file('image')->store('blogs');

            $blog = Blog::create($data);

            return ResponseFormatter::success($blog, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function updated(Request $request, $id)
    {
        $rules = [
            'authorId' => 'required|exists:users,id|numeric',
            'blogCategoryId' => 'required|exists:blog_category,id|numeric',
            'title' => 'required|string',
            'image' => 'image',
            'body' => 'required|string',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $blog = Blog::find($id);
            if (!$blog) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $findBlog = Blog::where('title', strtolower($request->title))->first();
            if ($blog->title !== $request->title && $findBlog) {
                return ResponseFormatter::error(null, 'Title already exists', 400);
            }

            $data = [
                'authorId' => $request->authorId,
                'blogCategoryId' => $request->blogCategoryId,
                'title' => $request->title,
                'body' => $request->body,
            ];

            if ($request->image) {
                // Delete
                Storage::delete($blog->image);
                // Save
                $data['image'] = $request->file('image')->store('blogs');
            }

            $blog->fill($data);
            $blog->save();

            return ResponseFormatter::success($data, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function showAll(Request $request)
    {
        try {
            $title = $request->input('title');
            $categoryId = $request->input('categoryId');
            $authorId = $request->input('authorId');
            $showDeleted = $request->input('showDeleted');
            $blog = Blog::query()->with(['category', 'author']);

            if ($title) {
                $blog->where('title', 'like', '%' . $title . '%');
            }
            if ($categoryId) {
                $blog->where('blogCategoryId', $categoryId);
            }
            if ($authorId) {
                $blog->where('authorId', $authorId);
            }
            if ($showDeleted) {
                $blog->withTrashed();
            }

            return ResponseFormatter::success($blog->get(), 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $offset = $request->input('offset') ?? 0;
            $limit = $request->input('limit') ?? 5;
            $title = $request->input('title');
            $categoryId = $request->input('categoryId');
            $authorId = $request->input('authorId');
            $showDeleted = $request->input('showDeleted');
            $blog = Blog::query()->with(['category', 'author']);

            if ($title) {
                $blog->where('title', 'like', '%' . $title . '%');
            }
            if ($categoryId) {
                $blog->where('blogCategoryId', $categoryId);
            }
            if ($authorId) {
                $blog->where('authorId', $authorId);
            }
            if ($showDeleted) {
                $blog->withTrashed();
            }

            $count = $blog->get()->count();
            $data = $blog->offset(((int)$offset) * ((int)$limit))->limit((int)$limit);

            return ResponseFormatter::pagination($data->get(), 'Success', $count, $offset, $limit);
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function detail($id)
    {
        try {
            $category = Blog::find($id);
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
            $category = Blog::find($id);
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
            $category = Blog::withTrashed()->find($id);
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
            $category = Blog::withTrashed()->find($id);
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
