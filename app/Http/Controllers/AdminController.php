<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class adminController extends commonFunction
{
    public function index(Request $request)
    {
        try {

            if ($request->ajax()) {
                // Base query
                $query = Admin::select('uid', 'name', 'email', 'phone', 'profile', 'created_at', 'status', 'deleted_at');

                // ✅ Trash filter
                if ($request->boolean('trashAdmin')) {
                    $query = $query->onlyTrashed(); // Only soft-deleted admins
                }

                // ✅ Search filter
                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                }

                // ✅ Pagination
                $page = $request->input('page', 1);
                $perPage = $request->input('per_page', 10);
                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                // ✅ Status stats (always from full set including trashed)
                $stats = [
                    'total' => Admin::withTrashed()->count(),
                    'public' => Admin::where('status', true)->count(),
                    'private' => Admin::where('status', false)->count(),
                    'trash' => Admin::onlyTrashed()->count(),
                ];

                // ✅ Return full response
                return response()->json([
                    'data' => view('admin.append', ['data' => $data])->render(),
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

            return view('admin.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // ✅ Step 1: Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admins,email',
                'phone' => 'required|string|max:20|unique:admins,phone',
                'password' => 'required|string|min:6|max:255',
                'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // ✅ Step 2: Handle image upload
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

            // ✅ Step 3: Create admin
            Admin::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'profile' => $profilePath,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Admin created successfully.',
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

    /**
     * Display the specified resource.
     */
    public function show(string $uid)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uid)
    {
        try {

            $admin = Admin::where('uid', $uid)->first();

            if (!$admin) {
                return redirect("/404");
            }

            return view('admin.edit', compact('admin'));

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uid)
    {
        try {
            // ✅ Step 1: Find the admin
            $admin = Admin::where('uid', $uid)->first();
            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Admin not found.',
                ], 404);
            }

            // ✅ Step 2: Validate input
            $validated = $request->validate([
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
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Admin updated successfully.',
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uid)
    {
        try {
            // Include trashed records in the search
            $admin = Admin::withTrashed()->where('uid', $uid)->first();

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Admin not found',
                ], 404);
            }

            if ($admin->trashed()) {
                // ✅ Restore if already deleted
                $admin->restore();

                return response()->json([
                    'error' => false,
                    'message' => 'Admin restored successfully',
                ]);
            } else {
                // ✅ Soft delete otherwise
                $admin->delete();

                return response()->json([
                    'error' => false,
                    'message' => 'Admin deleted successfully',
                ]);
            }

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function status(string $uid)
    {
        try {

            $admin = Admin::where('uid', $uid)->first();

            if (!$admin) {
                return response()->json([
                    'error' => true,
                    'message' => 'Admin not found',
                ]);
            }

            if ($admin->status) {
                $admin->status = false;
            } else {
                $admin->status = true;
            }

            $admin->save();

            return response()->json([
                'error' => false,
                'message' => 'Admin Status Updated successfully',
            ]);
        } catch (\Throwable $th) {
            // Handle exceptions
            return $this->tryCatchResponse($th);
        }
    }

}
