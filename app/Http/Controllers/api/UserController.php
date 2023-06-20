<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function add_role(Request $request){
        $user = User::find($request->user_id);
        $user->roles()->attach($request->role_id);
        $data_response = [
            'message' => 'Role attached to user succesfully',
            'user'=> $user
        ];

        return response()->json($data_response);
    }
}
