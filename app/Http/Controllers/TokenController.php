<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    public function createToken(Request $req) {
        $userCheck = DB::table('users')
                        ->where('email', $req->email)
                        ->get();
        if ($userCheck->count() == 1) {
            $time = date('Y-m-d H:i:s');
            $token = base64_encode($req->email).'.'.base64_encode($time);
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
            return response(json_encode($response400, JSON_PRETTY_PRINT), 200);
        }
    }
    public function updateToken(Request $req) {
        $time = date('Y-m-d H:i:s', mktime()-(5*60));
        $token = DB::table('tokens')
                    ->where('email', $req->email)
                    ->where('token', $req->token)
                    ->where('updated_at', '>', $time);
        if (!empty($token->first())) {
            $token->update([
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $response200 = [
                'code' => 200,
                'description' => 'OK',
                'message' => 'Update Token Success!',
                'result' => $token-first()
            ];
            return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
        } else {
            $response400 = [
                'code' => 400,
                'description' => 'BAD REQUEST',
                'message' => 'Update Token Failed!',
                'result' => ''
            ];
            return response(json_encode($response400, JSON_PRETTY_PRINT), 200);
        }
    }
    public function checkToken(Request $req) {
        $time = date('Y-m-d H:i:s', mktime()-(5*60));
        $token = DB::table('tokens')
                    ->where('email', $req->email)
                    ->where('token', $req->token)
                    ->where('updated_at', '>', $time);
        if (!empty($token->first())) {
            $response200 = [
                'code' => 200,
                'description' => 'OK',
                'message' => 'Check Token Success!',
                'result' => ''
            ];
            return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
        } else {
            $response400 = [
                'code' => 400,
                'description' => 'BAD REQUEST',
                'message' => 'Check Token Failed!',
                'result' => ''
            ];
            return response(json_encode($response400, JSON_PRETTY_PRINT), 200);
        }
    }
}
