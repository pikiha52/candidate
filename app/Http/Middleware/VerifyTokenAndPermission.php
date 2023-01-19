<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class VerifyTokenAndPermission
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
        $headers = $request->header();
        $token = isset($headers['authorization']) ? $headers['authorization'] : false;
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'token is required'
            ], 401);
        }

        $users = auth()->guard('api')->user();
        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'token token not valid'
            ], 401);
        }

        $currentPath = Route::getFacadeRoot()->current()->uri();
        $user = User::find($users->id)->getAllPermissions();
        $permission = collect($user)->where('name', explode('/', $currentPath)[3]);

        if (count($permission) < 1) {
            return response()->json([
                'success' => false,
                'message' => 'you dont have access this module'
            ], 400);
        }

        return $next($request);
    }
}
