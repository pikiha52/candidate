<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *    path="/auth/signin",
     *    operationId="index",
     *    tags={"Auth"},
     *    summary="Signin",
     *    description="Api for",
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           required={"email", "password"},
     *           @OA\Property(property="email", type="string", format="string", example="mrjohn@gmail.com"),
     *           @OA\Property(property="password", type="string", format="string", example="password"),
     *        ),
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="true"),
     *             @OA\Property(property="user",type="object")
     *          )
     *       ),
     *     @OA\Response(
     *          response=400, description="Failed",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="false"),
     *             @OA\Property(property="message",type="string", example="Email atau Password Anda salah")
     *          )
     *       )
     *  )
     */
    public function auth(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:5'
            ]);

            $credentials = $request->only('email', 'password');

            if (!$token = auth()->guard('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau Password Anda salah'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'user'    => auth()->guard('api')->user(),
                'token'   => 'Bearer ' . $token
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'message' => $err->getMessage(),
            ], 500);
        }
    }

    public function signout()
    {
        return response()->json([
            'success' => true,
            'message' => 'success signout'
        ], 200);
    }

}
