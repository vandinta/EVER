<?php

namespace App\Http\Controllers\API;

use App\Models\Jadwal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function index()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum login'
            ], 401);
        }
        
        $Jadwal = Jadwal::all();

        if (!$Jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak Ada Data Jadwal'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => $Jadwal
        ]);
    }

    public function create(Request $request)
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
            'hari'      => 'required',
            'kuota'     => 'required|numeric',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create jadwal
        $jadwal = Jadwal::create([
            'hari'      => $request->hari,
            'kuota'     => $request->kuota,
        ]);

        //return response JSON jadwal is created
        if ($jadwal) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal Berhasil Ditambahkan'
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
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

        $jadwal = Jadwal::where('id',$id)->get();;

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], 401);
        }
        return response()->json([
            'success' => true,
            'data' => $jadwal
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
            'hari'      => 'required',
            'kuota'     => 'required|number',
        ]);

        //update jadwal
        $jadwal = Jadwal::where('id',$request->id)->update([
            'hari'      => $request->hari,
            'kuota'     => $request->kuota,
        ]);

        //return response JSON jadwal is updated
        if ($jadwal) {
            return response()->json([
                'success' => true,
                'message' => 'Data Jadwal berhasil diupdate'
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function delete($id)
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum login'
            ], 401);
        }

        $removejadwal = Jadwal::where('id',$id)->delete;

        if (!$removejadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
