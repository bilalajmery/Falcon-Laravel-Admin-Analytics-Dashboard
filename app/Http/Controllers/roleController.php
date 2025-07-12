<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Role::select('uid', 'name', 'status', 'created_at', 'deleted_at');

                if ($request->boolean('trashCategory')) {
                    $query = $query->onlyTrashed();
                }

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $query->where('name', 'like', "%{$search}%");
                }

                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                $stats = [
                    'total' => Role::withTrashed()->count(),
                    'public' => Role::where('status', true)->count(),
                    'private' => Role::where('status', false)->count(),
                    'trash' => Role::onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('role.append', ['data' => $data])->render(),
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

            return view('role.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('role.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
            ]);

            Role::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'permission' => json_encode(config('access.array')),
                'status' => true,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Role created successfully.',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json([
                'error' => true,
                'message' => 'Validation failed.',
                'errors' => $th->errors(),
            ], 422);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function edit(string $uid)
    {
        try {
            $role = Role::where('uid', $uid)->firstOrFail();
            return view('role.edit', compact('role'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $role = Role::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100',
            ]);

            $role->update([
                'name' => $validated['name'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Role updated successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json([
                'error' => true,
                'message' => 'Validation failed.',
                'errors' => $th->errors(),
            ], 422);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function destroy(string $uid)
    {
        try {
            $role = Role::withTrashed()->where('uid', $uid)->firstOrFail();

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

            $role = Role::where('uid', $uid)->firstOrFail();
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

    public function permission(string $uid)
    {
        try {
            $role = Role::where('uid', $uid)->firstOrFail();
            // dd($role->permission);
            return view('role.permission', compact('role'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function permissionSave(Request $request)
    {
        try {
            $role = Role::where('uid', $request->uid)->firstOrFail();

            $permissionArray = config('access.array');
            $inputPermissions = $request->input('permissions', []);

            foreach ($permissionArray as $key => $value) {
                $permissionArray[$key] = isset($inputPermissions[$key]);
            }

            $role->permission = json_encode($permissionArray);
            $role->save();

            return response()->json([
                'error' => false,
                'message' => 'Permissions saved successfully.',
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

}
