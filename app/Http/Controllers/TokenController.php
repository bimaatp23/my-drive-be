<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    public function createToken(Request $req) {
        $userCheck = DB::table('users')
                        ->where('email', $req->email)
                        ->get();
        if ($userCheck->count() == 1) {
            $time = date('Y-m-d H:i:s');
            $token = Hash::make($req->email).Hash::make($time);
            DB::table('tokens')
                ->insert([
                    'email' => $req->email,
                    'token' => $token,
                    'created_at' => $time,
                    'updated_at' => $time
                ]);
            $token = DB::table('tokens')
                        ->where('token', $token)
                        ->first();
            $response200 = [
                'code' => 200,
                'description' => 'OK',
                'message' => 'Create Token Success!',
                'result' => $token
            ];
            return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
        } else {
            $response400 = [
                'code' => 400,
                'description' => 'BAD REQUEST',
                'message' => 'Create Token Failed!',
                'result' => ''
            ];
            return response(json_encode($response400, JSON_PRETTY_PRINT), 400);
        }
    }
    public function checkToken(Request $req) {
        
    }
}
