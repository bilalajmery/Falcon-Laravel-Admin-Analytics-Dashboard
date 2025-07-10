<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Type;
use Illuminate\Http\Request;

class typeController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Type::select('uid', 'name', 'image', 'status', 'created_at', 'deleted_at');

                if ($request->boolean('trashType')) {
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
                    'total' => Type::withTrashed()->count(),
                    'public' => Type::where('status', true)->count(),
                    'private' => Type::where('status', false)->count(),
                    'trash' => Type::onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('type.append', ['data' => $data])->render(),
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

            return view('type.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('type.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/type');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            Type::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'image' => $imagePath,
                'status' => true,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Type created successfully.',
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
            $type = Type::where('uid', $uid)->firstOrFail();
            return view('type.edit', compact('type'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $type = Type::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = $type->image;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/type');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            $type->update([
                'name' => $validated['name'],
                'image' => $imagePath,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Type updated successfully.',
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
            $type = Type::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($type->trashed()) {
                $type->restore();
                $message = 'Type restored successfully.';
            } else {
                $type->delete();
                $message = 'Type deleted successfully.';
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
            $type = Type::where('uid', $uid)->firstOrFail();
            $type->status = !$type->status;
            $type->save();

            return response()->json([
                'error' => false,
                'message' => 'Type status updated successfully.',
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
