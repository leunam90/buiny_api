<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::where('is_enable', true)->orderBy('first_name');
        if($request->has('id')){
            $query->where('first_name', 'LIKE', '%' . $request->id . '%');
            $query->orWhere('last_name', 'LIKE', '%' . $request->id . '%');
            $query->orWhere('sur_name', 'LIKE', '%' . $request->id . '%');
            $query->orWhere('phone_number', 'LIKE', '%' . $request->id . '%');
            $query->orWhere('email', 'LIKE', '%' . $request->id . '%');
        }
        $employees = $query->get();

        $data = [];
        foreach ($employees as $employee) {
            $data[] = [
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'sur_name' => $employee->sur_name,
                'phone_number' => $employee->phone_number,
                'email' => $employee->email,
                'is_enable' => $employee->is_enable,
                'user' => $employee->user
            ];
        }

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $employee = new Employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->sur_name = $request->sur_name;
            $employee->phone_number = $request->phone_number;
            $employee->email = $request->email;
            $employee->position = $request->position;
            $employee->save();

            return response()->json([
                "message" => "Successfully created",
                "employee" => $employee
            ], Response::HTTP_OK);
        }catch(\Exception $ex){
            return response()->json([
                "error" => true,
                "message" => $ex->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $data = [
            "message" => "Employee details",
            "employee" => $employee
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        try{
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->sur_name = $request->sur_name;
            $employee->phone_number = $request->phone_number;
            $employee->email = $request->email;
            $employee->position = $request->position;
            $employee->save();

            return response()->json([
                "message" => "Successfully updated",
                "employee" => $employee
            ], Response::HTTP_OK);
        }catch(\Exception $ex){
            return response()->json([
                "error" => true,
                "message" => $ex->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try{
            $employee->delete();

            return response()->json([
                "message" => "Successfully deleted",
                "employee" => $employee
            ], Response::HTTP_OK);
        }catch(\Exception $ex){
            return response()->json([
                "error" => true,
                "message" => $ex->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
