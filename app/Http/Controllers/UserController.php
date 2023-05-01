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
            'status' => 200,
            'message' => 'Get Users Success!',
            'data' => $users
        ];
        return response(json_encode($response200), 200);
    }
    public function user($email) {
        $user = DB::table('users')
                    ->where('email', $email)
                    ->first();
        $response200 = [
            'status' => 200,
            'message' => 'Get User Success!',
            'data' => [$user]
        ];
        return response(json_encode($response200), 200);
    }
    public function createUser(Request $req) {
        // DB::table('users')
        //     ->insert([
        //         'first_name' => $req->first_name,
        //         'last_name' => $req->last_name,
        //         'email' => $req->email,
        //         'password' => md5($req->password),
        //         'created_at' => date('Y-m-d H:i:s')
        //     ]);
        // $user = DB::table('users')
        //             ->where('email', $req->email)
        //             ->first();
        // $response200 = [
        //     'status' => 200,
        //     'message' => 'Create User Success!',
        //     'data' => [$user]
        // ];
        // return response(json_encode($response200), 200);
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
                'status' => 200,
                'message' => 'Update User Success!',
                'data' => [$user->first()]
            ];
            return response(json_encode($response200), 200);
        } else {
            $response400 = [
                'status' => 400,
                'message' => 'Wrong Password!',
                'data' => []
            ];
            return response(json_encode($response400), 400);
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
            'status' => 200,
            'message' => 'Delete User Success!',
            'data' => [$user]
        ];
        return response(json_encode($response200), 200);
    }
    public function login(Request $req) {
        $user = DB::table('users')
                    ->where('email', $req->email)
                    ->first();
        if (!empty($user)) {
            if ($user->password == md5($req->password)) {
                $response200 = [
                    'status' => 200,
                    'message' => 'Login User Success!',
                    'data' => [$user]
                ];
                return response(json_encode($response200), 200);
            } else {
                $response400 = [
                    'status' => 400,
                    'message' => 'Wrong Password!',
                    'data' => []
                ];
                return response(json_encode($response400), 400);
            }
        } else {
            $response400 = [
                'status' => 400,
                'message' => 'Email Not Registered!',
                'data' => []
            ];
            return response(json_encode($response400), 400);
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
                'status' => 200,
                'message' => 'Register User Success!',
                'data' => [$user->first()]
            ];
            return response(json_encode($response200), 200);
        } else {
            $response400 = [
                'status' => 400,
                'message' => 'Email Already Registered!',
                'data' => []
            ];
            return response(json_encode($response400), 400);
        }
    }
}
