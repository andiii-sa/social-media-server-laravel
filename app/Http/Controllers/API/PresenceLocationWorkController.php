<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\PresenceLocationWork;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PresenceLocationWorkController extends Controller
{
    private $rules = [
        'name' => ['required', 'string'],
        'clockIn' => ['string'],
        'clockOut' => ['required', 'string'],
        'isRequiredLocation' => ['boolean'],
        'isRequiredPhoto' => ['boolean'],
    ];

    public function created(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $findDay = PresenceLocationWork::where('name', strtolower($request->name))->first();
            if ($findDay) {
                return ResponseFormatter::error(null, 'Data already exists', 400);
            }

            $day = PresenceLocationWork::create([
                'name' => $request->name,
                'clockIn' => $request->clockIn,
                'clockOut' => $request->clockOut,
                'isRequiredLocation' => $request->isRequiredLocation,
                'isRequiredPhoto' => $request->isRequiredPhoto,
            ]);

            return ResponseFormatter::success($day, 'Success');
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

            $day = PresenceLocationWork::find($id);
            if (!$day) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $findDay = PresenceLocationWork::where('name', strtolower($request->name))->first();
            if ($day->name !== $request->name && $findDay) {
                return ResponseFormatter::error(null, 'Data already exists', 400);
            }

            $day->fill($request->all());
            $day->save();

            return ResponseFormatter::success($day, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function showAll(Request $request)
    {
        try {
            $name = $request->input('name');
            $showDeleted = $request->input('showDeleted');
            $day = PresenceLocationWork::query()->orderBy('name', 'asc');

            if ($name) {
                $day->where('name', 'like', '%' . $name . '%');
            }
            if ($showDeleted) {
                $day->withTrashed();
            }

            return ResponseFormatter::success($day->get(), 'Success');
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

            $day = PresenceLocationWork::query();

            if ($name) {
                $day->where('name', 'like', '%' . $name . '%');
            }
            if ($showDeleted) {
                $day->withTrashed();
            }

            $count = $day->get()->count();
            $data = $day->offset(((int)$offset) * ((int)$limit))->limit((int)$limit);

            return ResponseFormatter::pagination($data->get(), 'Success', $count, $offset, $limit);
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function detail($id)
    {
        try {
            $day = PresenceLocationWork::find($id);
            if (!$day) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            return ResponseFormatter::success($day, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function deleted($id)
    {
        try {
            $day = PresenceLocationWork::find($id);
            if (!$day) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $day->delete();

            return ResponseFormatter::success($day, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function forceDeleted($id)
    {
        try {
            $day = PresenceLocationWork::withTrashed()->find($id);
            if (!$day) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $day->forceDelete();

            return ResponseFormatter::success($day, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function restored($id)
    {
        try {
            $day = PresenceLocationWork::withTrashed()->find($id);
            if (!$day) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $day->restore();

            return ResponseFormatter::success($day, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }
}
