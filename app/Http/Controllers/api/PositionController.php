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
    public function index()
    {
        $positions = Position::all();

        return response()->json($positions);
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

        return response()->json($data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        //
    }
}
