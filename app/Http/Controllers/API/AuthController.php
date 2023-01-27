<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;
use Laravel\Sanctum\HasApiTokens;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendMailToUser;
use App\Mail\NotifyUser;


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
            $success['session'] = env('SESSION_LIFETIME');

           
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully',
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

    /**
     *  Update user
     *  @return user data
     */
    public function updateUser(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $valid = $request->validate([
            'id'    => 'required',
            'name'  => 'required',
            'email' => "bail|required|email|unique:users,email, $request->id"
        ]);
        $user = User::find($request->id);

        $status = $user->update($request->all());

        return $user;
    }


    /**
     * Verify OTP Before Change password
     * @return boolean    
     */

    public function verifyEmail(Request $request)
    {

        $genOTP = substr(str_shuffle("123456789"), 0, 5);
        // return $genOTP;
        $saveOTP = User::find(Auth::id())->update([
            'verify_otp' => $genOTP
        ]); 
        $mailData = [
            'userInfo'  => Auth::user(),
            'otpCode'  => $genOTP,
        ];

        $sendEmail = Mail::to($mailData['userInfo']['email'])->queue(new NotifyUser($mailData));
    }

    /**
     * Update user password
     * @return user data
     */

    public function updatePassword(Request $request)
    {


        $validated = $request->validate([
            'password'      => 'required|min:4',
            'c_password'    => 'required|same:password',
            'verify_otp'    => 'required|min:5'
        ]);

        if (!$validated) {
            return response()->json(['success' => true]);
        }

        $otp_code = Auth::user()->select('verify_otp')->first();
        if ($otp_code->verify_otp === $request->verify_otp) {
            $update = Auth::user()->update([
                'password' => Hash::make($request->password),
                'verify_otp'    => null,
            ]);
            return response()->json(['success' => true, 'result' => $update ]);
        }else{
            return response()->json(['success' => false, 'result' => null ]);
        }
        
    }
}
