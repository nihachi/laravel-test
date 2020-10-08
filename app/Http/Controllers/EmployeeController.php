<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|unique:employees,email',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'status' => 'error', 'errors' => $validator->errors()]);
        }

        if (Employee::create($request->all()) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
        }

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'status' => 'error', 'errors' => $validator->errors()]);
        }

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([ 'status' => 'error' ], 404);
        }

        if ( $employee->update($request->all()) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error'];
        }

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([ 'status' => 'success' ], 200);
    }

    // Import Employees from seeder
    public function importEmployee(){
        \Artisan::call('db:seed', array('--class' => 'EmployeeSeeder'));
        return response()->json([ 'status' => 'success' ], 200);
    }
}
