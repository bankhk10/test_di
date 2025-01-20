<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Role_users;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use Session;
use Illuminate\Support\Facades\Log;


class CustomAuthController extends Controller
{
    protected $role_users;
    public function __construct(
        Role_users $role_users

    ) {
        $this->role_users = $role_users;
    }

    public function login()
    {
        $url_redirect = env('APP_VBNEXT');
        return redirect($url_redirect);
    }
    public function loginUser(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'password' => 'required'
        ], [
            'code.required' => 'ป้อนรหัสพนักงาน',
            'password.required' => 'ป้อนรหัสผ่าน'
        ]);

        // Find the user based on the provided code or old_code
        $user = User::where(function ($query) use ($request) {
            $query->where('code', $request->code)
                ->orWhere('old_code', $request->code);
        })->where('active', 1)->first();

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'error' => 'Invalid credentials. User not found.',
            ], 401);
        }

        // Check if the user is active and not resigned
        if ($user->active == 0 || $user->resign_date !== null) {
            return response()->json([
                'error' => 'User is inactive or has resigned.',
            ], 403);
        }

        // Check the user's role
        // $role = Role_user::where('user_id', $user->user_id)->where('active', 1)->first();
        // if (!$role) {
        //     return response()->json([
        //         'error' => 'You do not have the necessary permissions to log in.',
        //     ], 403);
        // }

        // Verify the password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Incorrect password. Please try again.',
            ], 401);
        }

        // Check if the user needs to update their password
        if ($user->is_auth == 0) {
            return response()->json([
                'error' => 'Password change required. Please update your password.',
                'redirect' => '/change-password',
            ], 403);
        }

        // Create the session data
        $request->session()->put('loginId', $user->user_id);
        $request->session()->put('code', $user->code);

        // DB::table('vbeyond_carddigital.log_login')->insert([
        //     'username' => $user->code,
        //     'dates' => date('Y-m-d'),
        //     'timeStm' => date('Y-m-d H:i:s'),
        //     'page' => 'rantal'
        // ]);

        // Log::addLog($request->session()->get('loginId'), 'Login', 'Login');

        // Return success response
        return response()->json([
            'message' => 'Login successful.',
            'redirect' => "/showcard/{$user->user_id}",
        ], 200);
    }

    public function logoutUser(Request $request)
    {
        if ($request->session()->has('loginId')) {
            // Log the logout activity
            Log::addLog($request->session()->get('loginId'), 'Logout', 'User has logged out.');

            // Clear the session data for the user
            $request->session()->forget('loginId');

            // Return a success JSON response
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully. See you again soon!'
            ], 200);
        }

        // Return an error JSON response if no session exists
        return response()->json([
            'success' => false,
            'message' => 'You are not logged in.'
        ], 400);
    }

    public function AllowLoginConnect(Request $request, $id, $token)
    {

        $user = User::where('user_id', '=', $id)->first();
        if ($user) {
            $request->session()->put('loginId', $user->user_id);
            $checkToken = User::where('token', '=', $token)->first();

            if ($checkToken) {
                $role_user = $this->role_users->findByUserId($id);
                if (blank($role_user)) {
                    return redirect('/');
                }
                $id = $request->session()->get('loginId');

                if ($role_user->role_type == 'admin') {
                    return redirect('/admin');
                } else {
                    return redirect("/user/{$id}&{$token}");
                }

                // DB::table('vbeyond_carddigital.log_login')->insert([
                //     'username' => $user->code,
                //     'dates' => date('Y-m-d'),
                //     'timeStm' => date('Y-m-d H:i:s'),
                //     'page' => 'rantal'
                // ]);

                // Log::addLog($request->session()->get('loginId'), 'Login', 'Login AllowLoginConnect By vBisConnect');
                return redirect("/showcard/{$id}");
            } else {
                $request->session()->pull('loginId');
                return redirect('/');
            }
        } else if ($user->active == 0) {
            $request->session()->pull('loginId');
            return redirect('/');
        } else {
            return redirect('/');
        }
    }

    public function changePassword()
    {
        return view('auth.password');
    }

    public function updatePassword(Request $request)
    {
        $user = User::where('id', Session::get('dataIsAuth')->id)->first();
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/', //one lowercase letter
                'regex:/[A-Z]/', //one uppercase letter
                'regex:/[0-9]/', //one least one digit
                'regex:/[@$!%*#?&]/', //one least one character
            ],

            'cfpassword' => ['required', 'same:password']

        ], [
            'password.required' => 'ป้อนรหัสผ่านใหม่',
            'cfpassword.same' => 'รหัสผ่านไม่ตรงกัน',
            'password.min' => 'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
            'password.regex' => 'รหัสผ่านอย่างน้อยต้องมี ตัวพิมพ์เล็ก 1 ตัว,ตัวพิมพ์ใหญ่ 1 ตัว,ตัวเลข 1 ตัว และอักษรพิเศษ 1 ตัว',
            'cfpassword.required' => 'ป้อนยืนยันรหัสผ่านใหม่',

        ]);

        if (Hash::check($request->password, $user->password)) {
            Alert::warning('รหัสผ่านซ้ำกับรหัสเดิม', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        } else {
            $user->old_password = $user->password;
            $user->password = Hash::make($request->password);
            $user->is_auth = "1";
            $user->save();

            $user->refresh();

            $request->session()->put('loginId', $user->id);

            // DB::table('vbeyond_carddigital.log_login')->insert([
            //     'username' => $user->code,
            //     'dates' => date('Y-m-d'),
            //     'timeStm' => date('Y-m-d H:i:s'),
            //     'page' => 'Rantal'
            // ]);
            // Log::addLog($request->session()->get('loginId'), 'Update', 'Change Password');
            // Log::addLog($request->session()->get('loginId'), 'Login', 'Login');


            Alert::success('เข้าสู่ระบบสำเร็จ!');
            return redirect('/');
        }
    }
}
