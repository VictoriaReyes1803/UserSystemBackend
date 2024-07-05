<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:api',
            except: ['login', 'create']),
        ];
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);
        Log::info($request->all());
        if ($validator->fails()) {
            log::info($validator->errors());
            return response()->json(['error' => $validator->errors()], 422);
        }
        

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'Email not found or password incorrect'], 404);
        }
        if (!$token = auth('api')->attempt($credentials)) {
            log::info('j',$token);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    
    
        /**
         * Display the specified resource.
         */
        public function me()
        {
            if (!$user = auth('api')->user()) { 
                return response()->json(['error' => 'Unauthorized'], 401);
            } else {
                return response()->json(Auth::guard('api')->user());
            }
        }
    
        public function verifycode(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'verification_code' => 'required|string|min:6|max:6',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        
            $user = Auth::guard('api')->user();
            if (!$user) {
                return response()->json(['error' => 'No se pudo autenticar al usuario.'], 404);
            }
    
            $verificationCode = $request->input('verification_code');
            if (Hash::check($verificationCode, $user->token_verificacion)) {
                $user->email_verified_at = now();
                $user->verificado = true;
                $user->save();
                return response()->json(['message' => 'Cuenta activada correctamente.'], 200);
            } else {
                $user->verificado = false;
                $user->save();
                return response()->json(['error' => 'Código de verificación inválido.'], 400);
            }
        }
    
         /**
         * Log the user out (Invalidate the token).
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function logout()
        { 
            $user = Auth::guard('api')->user();
            //$user->token_verificacion = null;
            //$user->save();
    
            if ($user) { 
                Auth::guard('api')->logout();
                return response()->json(['message' => 'Successfully logged out'],200);
            }
            return response()->json(['message' => 'User not authenticated or not active'], 401);
        }
    
        /**
         * Refresh a token.
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function refresh()
        {
            return $this->respondWithToken(Auth::guard('api')->refresh());
        }
    
        /**
         * Get the token array structure.
         *
         * @param  string $token
         *
         * @return \Illuminate\Http\JsonResponse
         */
        protected function respondWithToken($token)
        {
            return response()->json([
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 6000
                ]
            ]);
        }
}
