<?php

namespace App\Http\Controllers\API;

use App\Exports\PresenceEmployeeExport;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\PresenceEmployee;
use App\Models\PresenceListDay;
use App\Models\PresenceScheduleEmployee;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Tymon\JWTAuth\Facades\JWTAuth;

class PresenceEmployeeController extends Controller
{

    public function created(Request $request, $type, $date)
    {
        $rules = [
            // 'employeeId' => ['required', 'string'],
            'dayId' => ['required', 'exists:presence_list_day,id'],
            'clockIn' => ['date'],
            'clockOut' => ['date'],
            'image' => ['required', 'image'],
            'longitude' => ['required', 'string'],
            'latitude' => ['required', 'string'],
        ];

        DB::beginTransaction();
        $image = '';

        try {
            if (!in_array($type, ['clock-in', 'clock-out'])) {
                return ResponseFormatter::error(null, 'Type invalid', 404);
            }

            $validatorDate = Validator::make(
                ['date' => $date],
                [
                    'date' => 'required|date_format:Y-m-d',
                ],
                [
                    'date_format' => 'Format date MUST YYYY-MM-DD',
                ]
            );
            if ($validatorDate->fails()) {
                return ResponseFormatter::error($validatorDate->errors(), 'Failed Format Date', 400);
            }

            $isTypeClockIn = $type === 'clock-in' ? true : false;

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $findDay = PresenceListDay::find($request->dayId);
            $user = JWTAuth::parseToken()->authenticate();

            $schedule = PresenceScheduleEmployee::query()
                ->where('employeeId', $user->id)
                ->where('dayId', $request->dayId)->first();

            if (!$schedule) {
                return ResponseFormatter::error(null, 'You Dont Have Schedule', 404);
            }
            $data = [
                'employeeId' => $user->id,
                'dayId' => $request->dayId,
                'dayName' => $findDay->name,
                // 'clockIn' => $request->clockIn,
                // 'clockOut' => $request->clockOut,
                // 'image' => $request->image,
                // 'longitude' => $request->longitude,
                // 'latitude' => $request->latitude,
            ];
            if ($isTypeClockIn) {
                $data['clockIn'] = $request->clockIn;
            } else {
                $data['clockOut'] = $request->clockOut;
            }

            $findPresence = PresenceEmployee::whereDate('created_at', $date)->first();
            $imageTemp = (object)[];
            $longitudeTemp = (object)[];
            $latitudeTemp = (object)[];
            $presence = '';

            if ($isTypeClockIn && !$request?->clockIn) {
                return ResponseFormatter::error(null, 'Field clockIn Must Required', 400);
            }
            if (!$isTypeClockIn && !$request?->clockOut) {
                return ResponseFormatter::error(null, 'Field clockOut Must Required', 400);
            }

            if (!$isTypeClockIn && !$findPresence?->clockIn) {
                return ResponseFormatter::error(null, 'You Must Clock IN First.', 400);
            }

            $image = $request->file('image')->store('presences');

            if ($findPresence) {
                $imagePrev = $findPresence->image ?? '';
                $longitudePrev = $findPresence->longitude ?? '';
                $latitudePrev = $findPresence->latitude ?? '';

                $imageTemp->clockIn = $isTypeClockIn ? $image : $imagePrev->clockIn ?? null;
                $imageTemp->clockOut = $isTypeClockIn ? $imagePrev->clockOut ?? null : $image;

                $longitudeTemp->clockIn = $isTypeClockIn ? $request->longitude : $longitudePrev->clockIn ?? null;
                $longitudeTemp->clockOut = $isTypeClockIn ? $longitudePrev->clockOut ?? null : $request->longitude;

                $latitudeTemp->clockIn = $isTypeClockIn ? $request->latitude : $latitudePrev->clockIn ?? null;
                $latitudeTemp->clockOut = $isTypeClockIn ? $latitudePrev->clockOut ?? null : $request->latitude;

                $data['image'] = json_encode($imageTemp);
                $data['longitude'] = json_encode($longitudeTemp);
                $data['latitude'] = json_encode($latitudeTemp);

                $findPresence->fill($data);
                $findPresence->save();
                $presence = $findPresence;
            } else {
                $imageTemp->clockIn = $isTypeClockIn ? $image : null;
                $imageTemp->clockOut = $isTypeClockIn ? null : $image;

                $longitudeTemp->clockIn = $isTypeClockIn ? $request->longitude : null;
                $longitudeTemp->clockOut = $isTypeClockIn ? null : $request->longitude;

                $latitudeTemp->clockIn = $isTypeClockIn ? $request->latitude : null;
                $latitudeTemp->clockOut = $isTypeClockIn ? null : $request->latitude;

                $data['image'] = json_encode($imageTemp);
                $data['longitude'] = json_encode($longitudeTemp);
                $data['latitude'] = json_encode($latitudeTemp);

                $presence = PresenceEmployee::create($data);
            }

            DB::commit();
            return ResponseFormatter::success($presence, 'Success');
        } catch (Exception $err) {
            Storage::delete($image);
            DB::rollback();
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function updated(Request $request, $id)
    {
        $rules = [
            'clockIn' => ['date'],
            'clockOut' => ['date'],
        ];
        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $presence = PresenceEmployee::find($id);
            if (!$presence) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $data = [
                'clockIn' => $request->clockIn,
                'clockOut' => $request->clockOut,
            ];

            $presence->fill($data);
            $presence->save();

            return ResponseFormatter::success($presence, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function showAll(Request $request)
    {
        try {
            $employeeId = $request->input('employeeId');
            $dayId = $request->input('dayId');
            $startDate  = $request->input('startDate');
            $endDate  = $request->input('endDate');
            $showDeleted = $request->input('showDeleted');
            $presence = PresenceEmployee::query()->with(['employee', 'day']);

            if ($employeeId) {
                $presence->where('employeeId', $employeeId);
            }
            if ($dayId) {
                $presence->where('dayId', $dayId);
            }
            if ($startDate) {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
                $presence->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
                $presence->whereDate('created_at', '<=', $endDate);
            }
            if ($showDeleted) {
                $presence->withTrashed();
            }

            return ResponseFormatter::success($presence->get(), 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $employeeId = $request->input('employeeId');
            $dayId = $request->input('dayId');
            $startDate  = $request->input('startDate');
            $endDate  = $request->input('endDate');
            $offset = $request->input('offset') ?? 0;
            $limit = $request->input('limit') ?? 5;
            $showDeleted = $request->input('showDeleted');

            $presence = PresenceEmployee::query()->with(['employee', 'day']);

            if ($employeeId) {
                $presence->where('employeeId', $employeeId);
            }
            if ($dayId) {
                $presence->where('dayId', $dayId);
            }
            if ($startDate) {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
                $presence->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
                $presence->whereDate('created_at', '<=', $endDate);
            }
            if ($showDeleted) {
                $presence->withTrashed();
            }

            $count = $presence->get()->count();
            $data = $presence->offset(((int)$offset) * ((int)$limit))->limit((int)$limit);

            return ResponseFormatter::pagination($data->get(), 'Success', $count, $offset, $limit);
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function detail($id)
    {
        try {
            $presence = PresenceEmployee::with(['employee', 'day'])->find($id);
            if (!$presence) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            return ResponseFormatter::success($presence, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function deleted($id)
    {
        try {
            $presence = PresenceEmployee::find($id);
            if (!$presence) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $presence->delete();

            return ResponseFormatter::success($presence, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function forceDeleted($id)
    {
        try {
            $presence = PresenceEmployee::withTrashed()->find($id);
            if (!$presence) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $presence->forceDelete();
            Storage::delete($presence?->image?->clockIn);
            Storage::delete($presence?->image?->clockOut);

            return ResponseFormatter::success($presence, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function restored($id)
    {
        try {
            $presence = PresenceEmployee::withTrashed()->find($id);
            if (!$presence) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $presence->restore();

            return ResponseFormatter::success($presence, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function showScheduleNow($dayName)
    {
        try {
            $day = PresenceListDay::where('name', 'like', '%' . $dayName . '%')->first();
            if (!$day) {
                return ResponseFormatter::error(null, 'Day not found', 404);
            }

            $user = JWTAuth::parseToken()->authenticate();
            $schedule = PresenceScheduleEmployee::query()->with(['employee', 'day', 'location_work'])
                ->where('employeeId', $user->id)
                ->where('dayId', $day->id)->first();

            if (!$schedule) {
                return ResponseFormatter::error(null, 'You Dont Have Schedule', 404);
            }

            return ResponseFormatter::success($schedule, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function showPresenceUserDetail($date)
    {
        try {
            $validatorDate = Validator::make(
                ['date' => $date],
                [
                    'date' => 'required|date_format:Y-m-d',
                ],
                [
                    'date_format' => 'Format date MUST YYYY-MM-DD',
                ]
            );
            if ($validatorDate->fails()) {
                return ResponseFormatter::error($validatorDate->errors(), 'Failed Format Date', 400);
            }

            $user = JWTAuth::parseToken()->authenticate();
            $schedule = PresenceEmployee::query()->with(['employee', 'day'])
                ->where('employeeId', $user->id)
                ->whereDate('created_at', $date)->first();

            $data = $schedule ?? (object)[];
            $data->isPresenceIn = isset($data->clockIn) ? true : false;
            $data->isPresenceOut = isset($data->clockOut) ? true : false;


            return ResponseFormatter::success($data, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function fileExportData()
    {
        try {
            return Excel::download(new PresenceEmployeeExport, 'presence-employee.xlsx');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }
}
