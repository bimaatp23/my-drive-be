<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Token');
        $time = date('Y-m-d H:i:s', mktime()-(10*60));
        $check = DB::table('tokens')
                    ->where('token', $token)
                    ->where('updated_at', '>', $time);
        if ($check->count() == 1) {
            $check->update([
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return $next($request);
        } else {
            $response403 = [
                'code' => 403,
                'description' => 'FORBIDDEN',
                'message' => '',
                'result' => ''
            ];
            return response(json_encode($response403, JSON_PRETTY_PRINT), 403);
        }
    }
}
