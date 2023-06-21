<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CurrentBudget;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrentBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $current_budget = CurrentBudget::all();
        return response()->json($current_budget, Response::HTTP_OK);
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
        $current_budget = new CurrentBudget();
        $current_budget->current_budget = $request->current_budget;
        $current_budget->save();

        $data = [
            "message" => "Successfully created",
            "current_budget" => $current_budget
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(CurrentBudget $currentBudget)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CurrentBudget $currentBudget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CurrentBudget $currentBudget)
    {
        $currentBudget->current_budget = $request->current_budget;
        $currentBudget->save();

        $data = [
            "message" => "Successfully updated",
            "current_budget" => $currentBudget
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurrentBudget $currentBudget)
    {
        //
    }
}
