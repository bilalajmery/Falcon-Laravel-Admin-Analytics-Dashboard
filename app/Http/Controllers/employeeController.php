<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class employeeController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Admin::with('role')->select('uid', 'name', 'email', 'phone', 'status', 'created_at', 'deleted_at', 'roleId')->where('type', 'EMPLOYEE');

                if ($request->boolean('trashEmployee')) {
                    $query = $query->onlyTrashed();
                }

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $query->where('name', 'like', "%{$search}%");
                }

                if ($request->filled('roleId')) {
                    $query->where('roleId', $request->roleId);
                }

                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                $stats = [
                    'total' => Admin::where('type', 'EMPLOYEE')->withTrashed()->count(),
                    'public' => Admin::where([['status', true], ['type', 'EMPLOYEE']])->count(),
                    'private' => Admin::where([['status', false], ['type', 'EMPLOYEE']])->count(),
                    'trash' => Admin::where('type', 'EMPLOYEE')->onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('employee.append', ['data' => $data])->render(),
                    'pagination' => [
                        'total' => $data->total(),
                        'per_page' => $data->perPage(),
                        'current_page' => $data->currentPage(),
                        'last_page' => $data->lastPage(),
                        'next_page_url' => $data->nextPageUrl(),
                        'prev_page_url' => $data->previousPageUrl(),
                        'from' => $data->firstItem() ?? 0,
                        'to' => $data->lastItem() ?? 0,
                    ],
                    'stats' => $stats,
                ]);
            }

            return view('employee.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('employee.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            // ✅ Step 1: Validate input
            $validated = $request->validate([
                'roleId' => 'required|string|max:255|exists:roles,uid',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admins,email',
                'phone' => 'required|string|max:20|unique:admins,phone',
                'password' => 'required|string|min:6|max:255',
                'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // ✅ Step 2: Handle image upload
            $profilePath = null;
            if ($request->hasFile('profile')) {
                $response = $this->storeImage($request->file('profile'), 'uploads/employee/profile');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $profilePath = $response['path'];
            }

            // ✅ Step 3: Create employee
            Admin::create([
                'uid' => (string) $this->uIdGenerate(),
                'roleId' => $validated['roleId'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'profile' => $profilePath,
                'type' => 'EMPLOYEE',
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Employee created successfully.',
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json([
                'error' => true,
                'message' => 'Validation failed.',
                'errors' => $th->errors(),
            ], 422);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Server error occurred.',
                'exception' => $th->getMessage(),
            ], 500);
        }
    }

    public function edit(string $uid)
    {
        try {
            $employee = Admin::where('uid', $uid)->firstOrFail();
            return view('employee.edit', compact('employee'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            // ✅ Step 1: Find the admin
            $admin = Admin::where('uid', $uid)->first();
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Employee not found.',
                ], 404);
            }

            // ✅ Step 2: Validate input
            $validated = $request->validate([
                'roleId' => 'required|string|max:255|exists:roles,uid',
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($admin->uid, 'uid')],
                'phone' => ['required', 'string', 'max:20', Rule::unique('admins', 'phone')->ignore($admin->uid, 'uid')],
                'password' => 'nullable|string|min:6|max:255',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // ✅ Step 3: Handle image upload
            $profilePath = $admin->profile;
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

            // ✅ Step 4: Update admin
            $admin->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => isset($validated['password']) ? Hash::make($validated['password']) : $admin->password,
                'profile' => $profilePath,
                'roleId' => $validated['roleId'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Employee updated successfully.',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json([
                'error' => true,
                'message' => 'Validation failed.',
                'errors' => $th->errors(),
            ], 422);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Server error occurred.',
                'exception' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $uid)
    {
        try {
            $role = Admin::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($role->trashed()) {
                $role->restore();
                $message = 'Role restored successfully.';
            } else {
                $role->delete();
                $message = 'Role deleted successfully.';
            }

            return response()->json([
                'error' => false,
                'message' => $message,
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function status(string $uid)
    {
        try {

            $role = Admin::where('uid', $uid)->firstOrFail();
            $role->status = !$role->status;
            $role->save();

            return response()->json([
                'error' => false,
                'message' => 'Role status updated successfully.',
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
