<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class settingController extends commonFunction
{
    public function index()
    {
        try {

            return view("setting.index");

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function personal(Request $request)
    {
        try {
            $uid = Session::get('adminSession.uid');
            $admin = Admin::where('uid', $uid)->first();

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Admin not found.',
                ], 404);
            }

            $admin->name = $request->name;
            $admin->phone = $request->phone;
            $admin->save();

            Session::put('adminSession.name', $request->name);
            Session::put('adminSession.phone', $request->phone);

            return response()->json([
                'error' => false,
                'message' => 'Personal information updated successfully.',
            ]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function twoStepVerification(Request $request)
    {
        try {
            $uid = Session::get('adminSession.uid');
            $admin = Admin::where('uid', $uid)->first();

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Admin not found.',
                ], 404);
            }

            $admin->twoStepVerification = $request->boolean('twoStepVerification');
            $admin->save();

            Session::put('adminSession.twoStepVerification', $request->twoStepVerification);

            return response()->json([
                'error' => false,
                'message' => 'Two Step Verification updated successfully.',
            ]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function password(Request $request)
    {
        try {

            $validated = $request->validate([
                'currentPassword' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8'],
                'confirmPassword' => ['required', 'string', 'min:8'],
            ]);

            $uid = Session::get('adminSession.uid');
            $admin = Admin::where('uid', $uid)->first();

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Admin not found.',
                ], 404);
            }

            if (!Hash::check($validated['currentPassword'], $admin->password)) {
                return response()->json(['error' => true, 'message' => 'Invalid current password']);
            }

            $admin->password = Hash::make($validated['password']);
            $admin->save();

            return response()->json([
                'error' => false,
                'message' => 'Password updated successfully.',
            ]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function profile(Request $request)
    {
        try {
            $uid = Session::get('adminSession.uid');
            $admin = Admin::where('uid', $uid)->first();

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Admin not found.',
                ], 404);
            }

            $profilePath = null;
            if ($request->hasFile('profile')) {
                $response = $this->storeImage($request->file('profile'), 'uploads/admin/profile');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $profilePath = $response['path'];
            }

            $profilePath ? $admin->profile = $profilePath : '';
            $admin->save();

            $profilePath ? Session::put('adminSession.profile', $profilePath) : '';

            return response()->json([
                'error' => false,
                'message' => 'Profile updated successfully.',
            ]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function accountDelete(Request $request)
    {
        try {

            $request->validate([
                'password' => ['required', 'string'],
            ]);

            $uid = Session::get('adminSession.uid');
            $admin = Admin::where('uid', $uid)->first();

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Admin not found.',
                ], 404);
            }

            if (!Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Incorrect password.',
                ], 403);
            }

            $admin->delete();

            Session::forget('adminSession');

            return response()->json([
                'error' => false,
                'message' => 'Your account has been deleted successfully.',
            ]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

}
