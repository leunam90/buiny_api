<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
            'sur_name' => 'required',
            'phone_number' => 'required'

        ]);

        try {
            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();

            $employee = new Employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->sur_name = $request->sur_name;
            $employee->phone_number = $request->phone_number;
            $employee->email = $request->email;
            $employee->position = $request->position;
            $employee->user_id = $user->id;
            $employee->save();

            return response($user, Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => $exception
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => "Email or password invalid"
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        $cookie = cookie('cookie_token', $token, 60 * 24);

        return response([
            "message" => "Access granted",
            "access_token" => $token,
            "token_type" => "Bearer",
            "user" => $user
        ], Response::HTTP_OK)->withoutCookie($cookie);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        // auth()->user()->tokens()->delete();

        return response()->json([
            'message' => "Log out successfuly"
        ], Response::HTTP_OK);
    }

    public function forgot_password(Request $request)
    {
        if (User::where('email', $request->email)->doesntExist()) {
            return response()->json([
                "message" => "User does not exist in database"
            ], Response::HTTP_NOT_FOUND);
        }

        $token = Str::random(16);

        try {
            DB::table('password_reset_tokens')->insert([
                "email" => $request->email,
                "token" => $token
            ]);

            return response()->json([
                "message" => "Email sended",
                "token" => $token
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(["message" => $exception], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reset_password(Request $request)
    {

        $token = $request->token;

        $request->validate([
            'password' => 'required|confirmed'
        ]);

        if (!$passwordReset = DB::table('password_reset_tokens')->where('token', $token)->first()) {
            return response()->json([
                "message" => "Invalid token"
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!$user = User::where('email', $passwordReset->email)->first()) {
            return response()->json([
                "message" => "User does't exist!"
            ], Response::HTTP_NOT_FOUND);
        }

        $user->password = $request->password;
        $user->save();

        DB::table('password_reset_tokens')->where('token', $token)->delete();

        return response()->json(["message" => "Password changed succesfully"], Response::HTTP_OK);
    }

    public function user_profile(Request $request)
    {
        $user_id = auth()->user()->id;

        $user = User::find($user_id);
        return response()->json([
            "message" => "User Profile",
            "user" => $user,
            "employee" => $user->employee,
            "roles" => $user->roles
        ], Response::HTTP_OK);
    }

    public function all_users()
    {
        $users = User::all();

        $users = User::all();
        $data = [];
        foreach($users as $user){
            $data[] = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'is_enabled' => $user->is_enable,
                'employee' => $user->employee,
                "roles" => $user->roles
            ];
        }

        return response()->json($data, Response::HTTP_OK);
    }
}
