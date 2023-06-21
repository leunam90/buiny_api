<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Position::query()->orderBy('name');

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $positions = $query->get();

        return response()->json($positions, Response::HTTP_OK);
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
            $position = new Position;
            $position->name = $request->name;

            $position->save();

            $data = [
                "message" => "Position created successfully",
                "position" => $position
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                "error" => true,
                "message" => $ex->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        $data = [
            "message" => "Position details",
            "position" => $position
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        try {
            $position->name = $request->name;
            $position->save();

            $data = [
                "message" => "Successfully updated",
                "position" => $position
            ];
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $ex) {
            $data = [
                "error" => true,
                "message" => $ex->getMessage()
            ];
            return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        try {
            $position->delete();

            $data = [
                "message" => "Succesfully deleted",
                "position" => $position
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $ex) {
            $data = [
                "error" => true,
                "message" => $ex->getMessage()
            ];

            return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
