<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\College;
use App\Course;
use App\Degree;

class ManagementController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function storeCollege(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string|max:191|unique:colleges',
            'description' => 'required|string|max:191|unique:colleges',
            'color_code' => 'required|string|max:191',
        ]);

        $college = College::create([
            'code' => $request['code'],
            'description' => $request['description'],
            'color_code' => $request['color_code'],
            'no_of_degrees' => 0,
        ]);

        return $college;
    }

    public function storeDegree(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string|max:191|unique:colleges',
            'description' => 'required|string|max:191|unique:colleges'
        ]);

        $degree = Degree::create([
            'code' => $request['code'],
            'description' => $request['description'],
            'college_code' => $request['college_code'],
            'college_id' => $request['college_id']
        ]);
        //Add College Degree Count
        $college = College::find($request['college_id']);
        $added = $college->no_of_degrees + 1;
        $college->update(['no_of_degrees' => $added]);

        return $degree;
    }

    public function storeCourse(Request $request)
    {
        $this->validate($request, [
            'degree_id' => 'required',
            'semester' => 'required',
            'year_level' => 'required',
            'course_code' => 'required',
            'course_description' => 'required',
            'units' => 'required',
            'lec' => 'required',
            'lab' => 'required',
            'total' => 'required',
        ]);

        $course = Course::create([
            'degree_id' => $request['degree_id'],
            'semester' => $request['semester'],
            'year_level' => $request['year_level'],
            'course_code' => $request['course_code'],
            'course_description' => $request['course_description'],
            'units' => $request['units'],
            'lec' => $request['lec'],
            'lab' => $request['lab'],
            'total' => $request['total'],
        ]);

        return $course;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDegree($id)
    {
        $degree = Degree::find($id);
        return $degree;
    }

    public function showAllColleges()
    {
        $colleges = College::latest()->get();

        foreach ($colleges as $college) {
            $college->degrees();
        }

        return $colleges;
    }

    public function showAllDegrees()
    {
        $degrees = Degree::latest()->get();

        return $degrees;
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

    public function destroyDegree($id)
    {
        $degree = Degree::findOrFail($id);
        $degree->delete();
        return $degree;
    }
}
