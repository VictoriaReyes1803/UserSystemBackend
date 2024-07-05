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

 
class UserController extends Controller
{  
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:api'),
        ];
    }
   /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function index()
    {   
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            log::info($validator->errors());
            return response()->json(['error' => $validator->errors()], 422);
        } else {
           $user = new User;
           $user->name = request()->name;
           $user->lastname = request()->lastname;
           $user->email = request()->email;
           $user->password = bcrypt(request()->password);
           $user->save();
            return response()->json([
                'data' => 'Usuario creado exitosamente.'
            ], 201);
    }}
    
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'lastname' => 'string',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'error' => 'User not found.'
            ], 404);
        }

        $user->update($request->all());

        return response()->json([
            'data' => 'User updated successfully.'
        ], 200);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
    
        $user->delete();
    
        return response()->json(['message' => 'User deleted successfully.'], 200);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   

}
