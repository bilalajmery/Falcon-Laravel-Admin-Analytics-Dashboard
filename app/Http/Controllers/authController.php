<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class authController extends commonFunction
{
    public function index()
    {
        try {

            return view('auth.login');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function login(Request $request)
    {
        try {

            // Validate input fields
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Fetch admin by email
            $admin = Admin::with(['role'])->where('email', $request->email)->first();

            // Check if admin exists
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            // Verify password
            if (!Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            // Check if account is disabled
            if ($admin->twoStepVerification) {
                $otp = $this->generateOtp();
                $sendOtp = $this->sendOtp($otp, $admin);
                if (isset($sendOtp['error'])) {
                    return response()->json(['error' => true, 'message' => $sendOtp['message']]);
                }

                $admin->otp = $otp;
                $admin->save();

                return response()->json([
                    'error' => false,
                    'twoStepVerification' => true,
                    'uid' => $admin->uid,
                    'message' => 'Redirect to Two Step Verification.',
                ], 200);
            }

            // Store email in cookie if remember me is checked
            if ($request->boolean('rememberMe')) {
                Cookie::queue('email', $admin->email, 60 * 24 * 365); // 1 year
            }

            // Store admin info in session
            Session::put('adminSession', [
                'adminId' => $admin->adminId,
                'uid' => $admin->uid,
                'name' => $admin->name,
                'email' => $admin->email,
                'profile' => $admin->profile,
                'cover' => $admin->cover,
                'twoStepVerification' => $admin->twoStepVerification,
                'phone' => $admin->phone,
                'type' => $admin->type,
                'role' => $admin->role?->name,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Login successfully.',
            ]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function logout(Request $request)
    {
        Session::forget('adminSession');
        Cookie::queue(Cookie::forget('email'));
        return redirect("/");
    }

    public function twoStepVerificationIndex($uid)
    {
        try {

            return view('twoStepVerification.index', ['uid' => $uid]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function twoStepVerification(Request $request)
    {
        try {

            $admin = Admin::where([['uid', $request->uid], ['otp', $request->otp]])->first();
            if (!$admin) {

                return response()->json(['error' => true, 'message' => 'Invalid OTP']);

            } else {

                $admin->otp = 0;
                $admin->save();

                Session::put('adminSession', [
                    'adminId' => $admin->adminId,
                    'uid' => $admin->uid,
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'profile' => $admin->profile,
                    'cover' => $admin->cover,
                    'twoStepVerification' => $admin->twoStepVerification,
                    'phone' => $admin->phone,
                ]);

                return response()->json(['error' => false, 'message' => 'Verified Successfully']);

            }
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function otpResend($uid)
    {
        try {

            $admin = Admin::where([['uid', $uid]])->first();
            if (!$admin) {
                return response()->json(['error' => true, 'message' => 'Account Not Found']);
            } else {

                $otp = $this->generateOtp();
                $sendOtp = $this->sendOtp($otp, $admin);
                if (isset($sendOtp['error'])) {
                    return response()->json(['error' => true, 'message' => $sendOtp['message']]);
                }

                $admin->otp = $otp;
                $admin->save();

                return response()->json(['error' => false, 'message' => 'OTP Resend Successfully']);
            }

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function forgotIndex()
    {
        try {

            return view('forgot.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function find(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
            ]);

            $admin = Admin::where('email', $request->email)->first();

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Account Not Found.',
                ], 404);
            }

            $otp = $this->generateOtp();
            $sendOtp = $this->sendOtp($otp, $admin);
            if (isset($sendOtp['error'])) {
                return response()->json(['error' => true, 'message' => $sendOtp['message']]);
            }

            $admin->otp = $otp;
            $admin->save();

            return response()->json([
                'error' => false,
                'message' => 'Account Found Successfully.',
                'uid' => $admin->uid,
            ]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function verificationIndex($uid)
    {
        try {

            return view('forgot.verification', ['uid' => $uid]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function verification(Request $request)
    {
        try {

            $admin = Admin::where([['uid', $request->uid], ['otp', $request->otp]])->first();
            if (!$admin) {

                return response()->json(['error' => true, 'message' => 'Invalid OTP']);

            } else {

                $admin->otp = 0;
                $admin->save();

                return response()->json(['error' => false, 'message' => 'Verified Successfully']);

            }
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function changePasswordIndex($uid)
    {
        try {

            return view('forgot.password', ['uid' => $uid]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function changePassword(Request $request)
    {
        try {

            $admin = Admin::where([['uid', $request->uid]])->first();
            if (!$admin) {

                return response()->json(['error' => true, 'message' => 'Invalid Uid']);

            } else {

                $admin->password = hash::make($request->password);
                $admin->save();

                return response()->json(['error' => false, 'message' => 'Password Changed Successfully']);

            }

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
