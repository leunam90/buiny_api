<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Role::where('is_enable', true);

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $roles = $query->get();
        return response()->json($roles, Response::HTTP_OK);
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
        try {
            $role = new Role;
            $role->name = $request->name;
            $role->save();

            $data_response = [
                'message' => 'Role created successfully',
                'role' => $role
            ];

            return response()->json($data_response, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(
                [
                    "error" => true,
                    "message" => $ex->getMessage()
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $data = [
            "message" => "Role details",
            "role" => $role
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return response()->json([
                "message" => "Successfully deleted",
                "role" => $role
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                "error" => true,
                "message" => $ex->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update_role_status(Request $request, Role $role)
    {
        $role->is_enable = $request->is_enable;
        $role->save();

        $message = "";
        if ($request->is_enable) {
            $message = "Role has been enabled susccesfully";
        } else {
            $message = "Role has been disabled susccesfully";
        }

        $data = [
            "message" => $message,
            "role" => $role
        ];

        return response()->json($data);
    }
}
