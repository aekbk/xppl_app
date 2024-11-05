<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use JWTAuth;

class user_controller extends Controller
{
    public function register(Request $request){
        try{
            $validations = request()->validate([
                'email' => 'required|string|email|unique:users|max:255',
                'password' => 'required|string|min:4|confirmed',
                'password_confirmation' => 'required|string',
            ]);

            $emailCheck = DB::table('user_email_registers')->where('email', $request->email);
            
            $explo = explode('@', $request->email);
            $userName = $explo[0];

            if (!$emailCheck->count()) {
                $success = false;
                $message = 'The email is not in the registered list';
            } else { 

                $user = new User();
                $user->email = $request->email;
                $user->username = $userName;
                $user->password = Hash::make($request->password);
                $user->save(); 

                $success = true;
                $message = "Sign up completed!";
            }
        } catch (\Illnminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }
        $response = [
            'success' => $success,
            'message' => $message
        ];
        return response()->json($response);
    }

    public function login(Request $request) {
        $validations = request()->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:4'
        ]);

        $token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password]);
        $loginData = Auth::user();

        if ($token) {
            $response = [
                'success' => true,
                'message' => 'Login completed',
                'loginData' => $loginData,
                'token' => $token
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Incorrect email or password'
            ];
        }
        return response()->json($response);
    }

    public function logout() {
        $token = JWTAuth::getToken();
        $invalidate = JWTAuth::invalidate($token);

        if ($invalidate) {
            $response = [
                'success' => true,
                'message' => 'Logout completed'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Logout failled'
            ];
        }
        return response()->json($response);
    }
}
