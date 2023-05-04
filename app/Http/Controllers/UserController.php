<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function allUsers() {
        $users = DB::table('users')->get();
        $response200 = [
            'code' => 200,
            'description' => 'OK',
            'message' => 'Get User List Success!',
            'result' => $users
        ];
        return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
    }
    public function user($email) {
        $user = DB::table('users')
                    ->where('email', $email)
                    ->first();
        if (!empty($user)) {
            $response200 = [
                'code' => 200,
                'description' => 'OK',
                'message' => 'Get User Success!',
                'result' => $user
            ];
            return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
        } else {
            $response400 = [
                'code' => 400,
                'description' => 'BAD REQUEST',
                'message' => 'Email Not Registered!',
                'result' => ''
            ];
            return response(json_encode($response400, JSON_PRETTY_PRINT), 200);
        }
    }
    public function createUser(Request $req) {
        
    }
    public function updateUser(Request $req) {
        $user = DB::table('users')
                    ->where('email', $req->email);
        if ($user->first()->password == md5($req->password)) {
            $user->update([
                    'first_name' => $req->first_name,
                    'last_name' => $req->last_name,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            $response200 = [
                'code' => 200,
                'description' => 'OK',
                'message' => 'Update User Success!',
                'result' => $user->first()
            ];
            return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
        } else {
            $response400 = [
                'code' => 400,
                'description' => 'BAD REQUEST',
                'message' => 'Wrong Password!',
                'result' => ''
            ];
            return response(json_encode($response400, JSON_PRETTY_PRINT), 200);
        }
    }
    public function deleteUser(Request $req) {
        $user = DB::table('users')
                    ->where('email', $req->email)
                    ->first();
        DB::table('users')
            ->where('email', $req->email)
            ->delete();
        $response200 = [
            'code' => 200,
            'description' => 'OK',
            'message' => 'Delete User Success!',
            'result' => $user
        ];
        return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
    }
    public function login(Request $req) {
        $user = DB::table('users')
                    ->where('email', $req->email)
                    ->first();
        if (!empty($user)) {
            if ($user->password == md5($req->password)) {
                $response200 = [
                    'code' => 200,
                    'description' => 'OK',
                    'message' => 'Login User Success!',
                    'result' => $user
                ];
                return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
            } else {
                $response400 = [
                    'code' => 400,
                    'description' => 'BAD REQUEST',
                    'message' => 'Login User Failed!',
                    'result' => [
                        'email' => '',
                        'password' => 'Wrong Password'
                    ]
                ];
                return response(json_encode($response400, JSON_PRETTY_PRINT), 200);
            }
        } else {
            $response400 = [
                'code' => 400,
                'description' => 'BAD REQUEST',
                'message' => 'Login User Failed!',
                'result' => [
                    'email' => 'Email Not Registered',
                    'password' => ''
                ]
            ];
            return response(json_encode($response400, JSON_PRETTY_PRINT), 200);
        }
    }
    public function register(Request $req) {
        $user = DB::table('users')
                    ->where('email', $req->email);
        if (empty($user->first())) {
            DB::table('users')
                ->insert([
                    'first_name' => $req->first_name,
                    'last_name' => $req->last_name,
                    'email' => $req->email,
                    'password' => md5($req->password),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            $response200 = [
                'code' => 200,
                'description' => 'OK',
                'message' => 'Register User Success!',
                'result' => $user->first()
            ];
            return response(json_encode($response200, JSON_PRETTY_PRINT), 200);
        } else {
            $response400 = [
                'code' => 400,
                'description' => 'BAD REQUEST',
                'message' => 'Email Already Registered!',
                'result' => ''
            ];
            return response(json_encode($response400, JSON_PRETTY_PRINT), 200);
        }
    }
}
