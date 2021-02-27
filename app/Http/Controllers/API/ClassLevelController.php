<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClassLevel;

class ClassLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels = ClassLevel::latest()->get();
        return $levels;
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
            'class_level_code' => 'required|unique:class_levels',
            'degree' => 'required',
            'year' => 'required',
            'section' => 'required',
            'no_of_students' => 'required',
        ]);

        $class = ClassLevel::create([
            'class_level_code' => $request['class_level_code'],
            'degree' => $request['degree'],
            'year' => $request['year'],
            'section' => $request['section'],
            'no_of_students' => $request['no_of_students'],
        ]);

        return $class;
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

    public function showClassInfo($id)
    {
        $class = ClassLevel::findOrFail($id);

        return $class;
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
