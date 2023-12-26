<?php

namespace App\Http\Controllers\API;

use App\Exports\PresenceScheduleEmployeeExport;
use App\Exports\PresenceScheduleEmployeeExportFormat;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Imports\PresenceScheduleEmployeeImport;
use App\Models\PresenceListDay;
use App\Models\PresenceLocationWork;
use App\Models\PresenceScheduleEmployee;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PresenceScheduleEmployeeController extends Controller
{
    private $rules = [
        'dayId' => ['required', 'exists:presence_list_day,id', 'numeric'],
        'employeeId' => ['required', 'exists:users,id', 'numeric'],
        'locationWorkId' => ['required', 'exists:presence_location_work,id', 'numeric'],
    ];

    public function created(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $findSchedule = PresenceScheduleEmployee::where('dayId', trim($request->dayId))
                ->where('employeeId', trim($request->employeeId))
                ->first();
            if ($findSchedule) {
                return ResponseFormatter::error(null, 'Schedule already exists', 400);
            }

            $schedule = PresenceScheduleEmployee::create([
                'dayId' => $request->dayId,
                'employeeId' => $request->employeeId,
                'locationWorkId' => $request->locationWorkId,
            ]);

            return ResponseFormatter::success($schedule, 'Success');
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

            $schedule = PresenceScheduleEmployee::find($id);
            if (!$schedule) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $findSchedule = PresenceScheduleEmployee::where('dayId', trim($request->dayId))
                ->where('employeeId', trim($request->employeeId))
                ->first();
            if ($findSchedule && (int)$id !== $findSchedule->id) {
                return ResponseFormatter::error(null, 'Data already exists', 400);
            }

            $schedule->fill($request->all());
            $schedule->save();

            return ResponseFormatter::success($schedule, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function showAll(Request $request)
    {
        try {
            $name = $request->input('name');
            $dayId = $request->input('dayId');
            $locationWorkId = $request->input('locationWorkId');
            $showDeleted = $request->input('showDeleted');
            $schedule = PresenceScheduleEmployee::query()->with(['employee', 'day', 'location_work']);

            if ($name) {
                $schedule->whereHas('employee', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                    $query->orWhere('username', 'like', '%' . $name . '%');
                    $query->orWhere('email', 'like', '%' . $name . '%');
                });
            }
            if ($dayId) {
                $schedule->whereHas('day', function ($query) use ($dayId) {
                    $query->where('id',  $dayId);
                });
            }
            if ($locationWorkId) {
                $schedule->whereHas('location_work', function ($query) use ($locationWorkId) {
                    $query->where('id',  $locationWorkId);
                });
            }

            if ($showDeleted) {
                $schedule->withTrashed();
            }

            return ResponseFormatter::success($schedule->get(), 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $name = $request->input('name');
            $dayId = $request->input('dayId');
            $locationWorkId = $request->input('locationWorkId');
            $offset = $request->input('offset') ?? 0;
            $limit = $request->input('limit') ?? 5;
            $showDeleted = $request->input('showDeleted');

            $schedule = PresenceScheduleEmployee::query()->with(['employee', 'day', 'location_work']);

            if ($name) {
                $schedule->whereHas('employee', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                    $query->orWhere('username', 'like', '%' . $name . '%');
                    $query->orWhere('email', 'like', '%' . $name . '%');
                });
            }
            if ($dayId) {
                $schedule->whereHas('day', function ($query) use ($dayId) {
                    $query->where('id',  $dayId);
                });
            }
            if ($locationWorkId) {
                $schedule->whereHas('location_work', function ($query) use ($locationWorkId) {
                    $query->where('id',  $locationWorkId);
                });
            }

            if ($showDeleted) {
                $schedule->withTrashed();
            }

            $count = $schedule->get()->count();
            $data = $schedule->offset(((int)$offset) * ((int)$limit))->limit((int)$limit);

            return ResponseFormatter::pagination($data->get(), 'Success', $count, $offset, $limit);
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function detail($id)
    {
        try {
            $schedule = PresenceScheduleEmployee::with(['employee', 'day', 'location_work'])->find($id);
            if (!$schedule) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            return ResponseFormatter::success($schedule, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function deleted($id)
    {
        try {
            $schedule = PresenceScheduleEmployee::find($id);
            if (!$schedule) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $schedule->delete();

            return ResponseFormatter::success($schedule, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function forceDeleted($id)
    {
        try {
            $schedule = PresenceScheduleEmployee::withTrashed()->find($id);
            if (!$schedule) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $schedule->forceDelete();

            return ResponseFormatter::success($schedule, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function restored($id)
    {
        try {
            $schedule = PresenceScheduleEmployee::withTrashed()->find($id);
            if (!$schedule) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            $schedule->restore();

            return ResponseFormatter::success($schedule, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function fileExportFormat()
    {
        try {
            return Excel::download(new PresenceScheduleEmployeeExportFormat, 'presence-schedule-employee-format.xlsx');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function fileImportData(Request $request)
    {
        try {
            $import = new PresenceScheduleEmployeeImport();
            $import->onlySheets('data_schedule_employee');
            $data = Excel::toArray($import, $request->file('file')->store('temp'));

            if (!array_key_exists('data_schedule_employee', $data)) {
                return ResponseFormatter::error(null, 'Sheet not found', 404);
            }

            if (count($data['data_schedule_employee']) < 1) {
                return ResponseFormatter::error(null, 'Empty data', 400);
            }

            if (!array_key_exists('id', $data['data_schedule_employee'][0]) || !array_key_exists('dayId', $data['data_schedule_employee'][0]) || !array_key_exists('employeeId', $data['data_schedule_employee'][0]) || !array_key_exists('locationWorkId', $data['data_schedule_employee'][0])) {
                return ResponseFormatter::error(null, 'Please follow the format excel.', 400);
            }

            $findEmptyField = false;
            foreach ($data['data_schedule_employee'] as $key => $val) {
                if (!trim($val['dayId'] ?? '') || !trim($val['employeeId'] ?? '') || !trim($val['locationWorkId']) ?? '') {
                    $findEmptyField = true;
                    break;
                }
            }

            if ($findEmptyField) {
                return ResponseFormatter::error(null, 'All field must be required', 400);
            }

            $invalidId = [];
            $invalidDayId = [];
            $invalidEmployeeId = [];
            $invalidLocationWorkId = [];
            foreach ($data['data_schedule_employee'] as $key => $val) {
                if (trim($val['id'] ?? '')) {
                    $findId = PresenceScheduleEmployee::find(trim($val['id']));
                    if (!$findId) {
                        array_push($invalidId, trim($val['id']));
                    }
                }

                $findDayId = PresenceListDay::find(trim($val['dayId']));
                if (!$findDayId) {
                    array_push($invalidDayId, trim($val['dayId']));
                }
                $findEmployeeId = PresenceListDay::find(trim($val['dayId']));
                if (!$findEmployeeId) {
                    array_push($invalidEmployeeId, trim($val['employeeId']));
                }
                $findLocationWorkId = PresenceLocationWork::find(trim($val['dayId']));
                if (!$findLocationWorkId) {
                    array_push($invalidLocationWorkId, trim($val['locationWorkId']));
                }
            }

            if (count($invalidId) > 0 || count($invalidDayId) > 0 || count($invalidEmployeeId) > 0 || count($invalidLocationWorkId) > 0) {
                $messages = count($invalidId) > 0 ? 'id [' . implode(', ', $invalidId) . '], ' : '';
                $messages = count($invalidDayId) > 0 ? $messages .  'dayId [' . implode(', ', $invalidDayId) . '], ' : '';
                $messages = count($invalidEmployeeId) > 0 ? $messages .  'employeeId [' . implode(', ', $invalidEmployeeId) . '], ' : '';
                $messages = count($invalidLocationWorkId) > 0 ? $messages .  'locationWorkId [' . implode(', ', $invalidLocationWorkId) . '], ' : '';
                $messages = $messages . 'not found';
                return ResponseFormatter::error(null, $messages, 404);
            }

            foreach ($data['data_schedule_employee'] as $key => $val) {
                if (trim($val['id'] ?? '')) {
                    //    Update
                    $schedule = PresenceScheduleEmployee::find(trim($val['id']));
                    $findSchedule = PresenceScheduleEmployee::where('dayId', trim($val['dayId']))
                        ->where('employeeId', trim($val['employeeId']))
                        ->first();
                    if ($findSchedule && (int)trim($val['id']) !== $findSchedule->id) {
                        // NEXT DATA
                    } else {
                        $schedule->fill([
                            'dayId' =>  trim($val['dayId']),
                            'employeeId' =>  trim($val['employeeId']),
                            'locationWorkId' =>  trim($val['locationWorkId']),
                        ]);
                        $schedule->save();
                    }
                } else {
                    //    Create
                    $findSchedule = PresenceScheduleEmployee::where('dayId', trim($val['dayId']))
                        ->where('employeeId', trim($val['employeeId']))
                        ->first();
                    if (!$findSchedule) {
                        // Create
                        $schedule = PresenceScheduleEmployee::create([
                            'dayId' =>  trim($val['dayId']),
                            'employeeId' =>  trim($val['employeeId']),
                            'locationWorkId' =>  trim($val['locationWorkId']),
                        ]);
                    } else {
                        // Update
                        $findSchedule->fill([
                            'dayId' =>  trim($val['dayId']),
                            'employeeId' =>  trim($val['employeeId']),
                            'locationWorkId' =>  trim($val['locationWorkId']),
                        ]);
                        $findSchedule->save();
                    }
                }
            }

            return ResponseFormatter::success(null, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function fileExportData()
    {
        try {
            return Excel::download(new PresenceScheduleEmployeeExport, 'presence-schedule-employee-all.xlsx');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }
}
