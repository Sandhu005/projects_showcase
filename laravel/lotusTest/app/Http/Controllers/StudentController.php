<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRegisterRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRegisterRequest $request)
    {
        $student = Student::create($request->validated());

        return $this->successResponse($student, 'Student has been stored!!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        if($student){
            return $this->successResponse($student, 'Student record found!');
        }else{
            return $this->errorResponse(404, 'Invalid Student!!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
