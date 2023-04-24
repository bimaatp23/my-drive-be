<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function allUsers() {
        $users = DB::table('users')->get();
        return response(json_encode($users), 200);
    }
    public function user($username) {
        $user = DB::table('users')
                    ->where('username', $username)
                    ->first();
        return response(json_encode($user), 200);
    }
    public function createUser(Request $req) {
        DB::table('users')
            ->insert([
                'name' => $req->name,
                'username' => $req->username,
                'password' => $req->password,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        return response('Create User Success!', 200);
    }
    public function updateUser(Request $req, $username) {
        DB::table('users')
            ->where('username', $username)
            ->update([
                'name' => $req->name,
                'password' => $req->password,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        return response('Update User Success!', 200);
    }
    public function deleteUser($username) {
        DB::table('users')
            ->where('username', $username)
            ->delete();
        return response('Delete User Success!', 200);
    }
}
