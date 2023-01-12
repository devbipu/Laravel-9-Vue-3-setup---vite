<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;
use Laravel\Sanctum\HasApiTokens;



class AuthController extends Controller
{
    use HasApiTokens;
    public function register(Request $req)
    {    
        $validator = Validator::make($req->all(), [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'password'  => 'required|min:4',
            'c_password'    => 'required|same:password'
        ]);

        if ($validator->fails()) {
            $response = [
                'success'   => false,
                'message'   => $validator->errors()
            ];
            return response()->json($response);
        }

        $input = $req->all();
        $input['password']  = bcrypt($input['password']);
        $user = User::create($input);
        //$success['token']   = $user->createToken('MyApp')->plainTextToken;
        //$success['name']    = $user->name;

        $response = [
            'success'   => true,
            'message'   => 'User Register Successfully',
        ];
        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email'=>$request->email, 'password' => $request->password])){
            $user = Auth::user();
            $request->session()->regenerate();
            $success['token'] = $user->createToken('Login')->plainTextToken;
            $success['name'] = $user->name;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully'
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'success' => false,
                'message' => 'Unauthorized'
            ];
            return response()->json($response);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $res = $request->user()->tokens()->delete();
            Auth::logout();
            return response()->json([
                'resutl' => $res,
                'from'  => 'Auth user Logout'
            ]);
        }else{
            Auth::logout();
            $res = User::find($request->id)->tokens()->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'resutl' => $res,
                'from'  => 'Gest user Logout'
            ]);
        }
        
    }
}