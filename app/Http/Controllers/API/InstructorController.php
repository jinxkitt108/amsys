<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Instructor;
use App\Employee;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructors = Instructor::latest()->get();
        return $instructors;
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
            'employee_id' => 'required|unique:employees',
            'name' => 'required|string|max:191',
            'gender' => 'required',
            'status' => 'required',
            'work_status' => 'required',
            'remarks' => 'required',
        ]);

        $instructor = Instructor::create([
            'name' => $request['name'],
            'gender' => $request['gender'],
            'status' => $request['status'],
            'work_status' => $request['work_status'],
            'remarks' => $request['remarks'],
        ]);

        if ($instructor) {
            $employee = Employee::create([
                'employee_id' => $request['employee_id'],
                'employeable_type' => 'App\Instructor',
                'employeable_id' => $instructor->id,
            ]);
        }
        $instructor->employee;
        return $instructor;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $instructor = Instructor::findOrFail($id);
        return $instructor;
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
