<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $guard;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Determine if the user is an admin
        $isAdmin = Admin::where('email', $credentials['email'])->exists();

        // Attempt to authenticate the user
        if ($isAdmin) {
            $this->guard = 'api-admins';
            if (!$token = Auth::guard($this->guard)->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            $this->guard = 'api';
            if (!$token = Auth::guard($this->guard)->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }

        // Return the token
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->guard($this->guard)->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard($this->guard)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return $this->respondWithToken($newToken);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'role'=>Auth::guard('api')->check()? "user" :"admin",
            'expires_in' => JWTAuth::factory()->getTTL() * 30000,
            'user' => auth()->guard($this->guard)->user()
        ]);
    }
}
