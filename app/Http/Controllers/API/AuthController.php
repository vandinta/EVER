<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => ['required', 'email'],
            'password'  => ['required']
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        //if auth failed
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'token'   => $token
        ], 200);
    }

    public function register(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        //return response JSON user is created
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil dibuat, silakan periksa email Anda untuk aktivasi'
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function users()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum login'
            ], 401);
        }

        $users = User::all();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function detail($id)
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum login'
            ], 401);
        }

        $users = User::where('id',$id)->get();;

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
    
    public function update(Request $request)
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum login'
            ], 401);
        }

        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'password'  => 'required|min:8|confirmed'
        ]);

        //update user
        $user = User::where('id',$request->id)->update([
            'name'      => $request->name,
            'password'  => bcrypt($request->password)
        ]);

        //return response JSON user is updated
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil diupdate'
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function logout(Request $request)
    {
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($removeToken) {
            //return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',
            ]);
        }
    }
}
