<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function show(User $user)
    {
        $data = [
            "message" => "User details",
            "user" => $user,
            "employee" => $user->employee,
            "roles" => $user->roles
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(Request $request, User $user)
    {
        try {
            $employee = $user->employee;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->sur_name = $request->sur_name;
            $employee->phone_number = $request->phone_number;
            $employee->save();

            return response()->json([
                "message" => "Successfully updated",
                "user" => $user,
                "employee" => $user->employee
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                "error" => true,
                "message" => $exception
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function add_role(Request $request)
    {
        $user = User::find($request->user_id);
        $user->roles()->attach($request->role_id);
        $data_response = [
            'message' => 'Role attached to user succesfully',
            'user' => $user
        ];

        return response()->json($data_response);
    }

    public function remove_role(Request $request)
    {
        $user = User::find($request->user_id);
        $user->roles()->detach($request->role_id);
        $data_response = [
            'message' => 'Role dettached to user succesfully',
            'user' => $user
        ];

        return response()->json($data_response);
    }
}
