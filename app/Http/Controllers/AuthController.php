<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()) return response()->json($validator->errors());       

        $customer = Customer::create([
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => $customer,'token' => $token]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) return response('Failed to login wrong email / password', 401);
        $customer = Customer::where('email', $request['email'])->firstOrFail();
        $token = $customer->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'You have successfully logged out'
        ];
    }
}
