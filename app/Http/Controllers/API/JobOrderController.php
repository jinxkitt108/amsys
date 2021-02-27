<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JobOrder;
use App\Employee;

class JobOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = JobOrder::latest()->get();
        return $staffs;
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
            'position_title' => 'required',
            'remarks' => 'required',
        ]);

        $staff = JobOrder::create([
            'name' => $request['name'],
            'gender' => $request['gender'],
            'status' => $request['status'],
            'position_title' => $request['position_title'],
            'remarks' => $request['remarks'],
        ]);

        if ($staff) {
            $employee = Employee::create([
                'employee_id' => $request['employee_id'],
                'employeable_type' => 'App\JobOrder',
                'employeable_id' => $staff->id,
            ]);
        }
        $staff->employee;
        return $staff;
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
