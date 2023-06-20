<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request){
        $query = Country::query();

        if($request->has('name')){
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $countries = $query->get();

        return response()->json($countries);

    }

    public function show(Country $country){
        $data = [
            "message" => "Country details",
            "country" => $country
        ];

        return response()->json($data);
    }
}
