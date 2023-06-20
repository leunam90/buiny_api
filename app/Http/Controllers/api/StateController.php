<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(Request $request){
        $query = State::query();

        if($request->has('country_id')){
            $query->where('country_id', $request->country_id);
        }
        if($request->has('name')){
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $states = $query->get();

        return response()->json($states);
    }

    public function show(State $state){
        $data = [
            "message" => "State details",
            "state" => $state
        ];

        return response()->json($data);
    }
}
