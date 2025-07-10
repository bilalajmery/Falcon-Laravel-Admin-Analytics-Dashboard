<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\SubType;
use Illuminate\Http\Request;

class subTypeController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = SubType::with('type')->select('uid', 'name', 'image', 'status', 'created_at', 'deleted_at', 'typeId');

                if ($request->boolean('trashCategory')) {
                    $query = $query->onlyTrashed();
                }

                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->input('search') . '%');
                }

                if ($request->filled('typeId')) {
                    $query->where('typeId', $request->input('typeId'));
                }

                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                $stats = [
                    'total' => SubType::withTrashed()->count(),
                    'public' => SubType::where('status', true)->count(),
                    'private' => SubType::where('status', false)->count(),
                    'trash' => SubType::onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('subType.append', ['data' => $data])->render(),
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

            return view('subType.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('subType.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'typeId' => 'required|uuid|exists:types,uid',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/subType');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            SubType::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'image' => $imagePath,
                'typeId' => $validated['typeId'],
                'status' => true,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'SubType created successfully.',
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
            $subType = SubType::where('uid', $uid)->firstOrFail();
            return view('subType.edit', compact('subType'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $subType = SubType::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'typeId' => 'required|uuid|exists:types,uid',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = $subType->image;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/subType');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            $subType->update([
                'name' => $validated['name'],
                'image' => $imagePath,
                'typeId' => $validated['typeId'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'SubType updated successfully.',
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
            $subType = SubType::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($subType->trashed()) {
                $subType->restore();
                $message = 'SubType restored successfully.';
            } else {
                $subType->delete();
                $message = 'SubType deleted successfully.';
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
            $subType = SubType::where('uid', $uid)->firstOrFail();
            $subType->status = !$subType->status;
            $subType->save();

            return response()->json([
                'error' => false,
                'message' => 'SubType status updated successfully.',
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
