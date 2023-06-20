<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request){
        $query = City::query();

        if($request->has('state_id')){
            $query->where('state_id', $request->state_id);
        }

        if($request->has('name')){
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $cities = $query->get();

        return response()->json($cities);
    }

    public function show(City $city){
        $data = [
            'message'=>'Details',
            'city' => $city
        ];

        return response()->json($data);
    }
}
