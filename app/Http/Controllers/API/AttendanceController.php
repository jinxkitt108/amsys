<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Builder;
use App\Attendance;
use App\Employee;
use App\Instructor;
use App\JobOrder;
use App\Log;
use Illuminate\Support\Carbon;
use stdClass;
use Symfony\Component\Mime\Encoder\ContentEncoderInterface;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::whereDate('created_at', Carbon::today())->get();
        foreach ($attendances as $item) {
            $employeable = Employee::where('employee_id', $item->employee_id)->first();
            $employee = $employeable->employeable_type::find($employeable->employeable_id);
            $item['employee'] = $employee;
        }
        return $attendances;
    }

    public function getAllEmployee()
    {
        return Employee::latest()->get();
    }

    public function getAllLogs()
    {
        return Log::whereDate('created_at', Carbon::today())->latest()->get();
    }

    public function getAllLogSet(Request $request)
    {
        return Log::whereDate('created_at', $request['date'])->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required',
        ]);

        $check = Employee::where('employee_id', $request['employee_id'])->exists();
        $log = Attendance::where('employee_id', $request['employee_id'])->whereDate('created_at', Carbon::today())->exists();

        if ($check) {
            if ($request['time_out'] === false) {
                if ($log) {
                    throw ValidationException::withMessages(['status' => 'This employee ALREADY TIMED IN today!']);
                }
            } else {
                $log = Attendance::where('employee_id', $request['employee_id'])->whereDate('time_out', Carbon::today())->exists();
                $login = Attendance::where('employee_id', $request['employee_id'])->whereDate('time_in', Carbon::today())->exists();
                if ($log) {
                    throw ValidationException::withMessages(['status' => 'This employee ALREADY TIMED OUT today!']);
                } else if (!$login) {
                    throw ValidationException::withMessages(['status' => 'This employee DID NOT TIME IN today!']);
                } else {
                    $now = Carbon::now();
                    $attendance = Attendance::where('employee_id', $request['employee_id'])->whereDate('created_at', Carbon::today());
                    $record = $attendance->first();
                    $time_in = $record->time_in;
                    $diff = $now->diff($time_in)->format('%H:%I:%S');

                    $attendance->update(['total_hours' => $diff]);
                    $attendance->update(['time_out' => $now]);
                    if ($attendance) {
                        $object = new stdClass;
                        $employeable = Employee::where('employee_id', $request['employee_id'])->first();
                        $employee = $employeable->employeable_type::find($employeable->employeable_id);
                        $object->employee = $employee;
                        $log = Log::create([
                            'action' => 'Time-Out',
                            'content' => $object
                        ]);
                        $attendance = $attendance->get();
                        $attendance['log'] = $log;
                        $attendance['employee'] = $employee;
                    }
                    return $attendance;
                }
            }

            $now = Carbon::now();
            $schedule = $now->copy()->startOfDay()->addHours(7)->addMinutes(30);
            if ($now->diffInSeconds($schedule)) {
                $dif = $now->diff($schedule);
                $status = $dif->h . ':' . $dif->i . ':' . $dif->s;
            } else {
                $status = null;
            }

            $attendance = Attendance::create([
                'employee_id' => $request['employee_id'],
                'time_in' => $now,
                'status' => $status
            ]);

            if ($attendance) {
                $object = new stdClass;
                $employeable = Employee::where('employee_id', $attendance->employee_id)->first();
                $employee = $employeable->employeable_type::find($employeable->employeable_id);
                $object->employee = $employee;
                $log = Log::create([
                    'action' => 'Time-In',
                    'content' => $object
                ]);
                $attendance['log'] = $log;
                $attendance['employee'] = $employee;
            }
            return $attendance;
        } else {
            throw ValidationException::withMessages(['status' => 'This Qr Code does not exist!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
