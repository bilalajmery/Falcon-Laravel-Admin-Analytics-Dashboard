<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Models;
use Illuminate\Http\Request;

class modelController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Models::with('make')->select('uid', 'name', 'image', 'status', 'created_at', 'deleted_at', 'makeId');

                if ($request->boolean('trashCategory')) {
                    $query = $query->onlyTrashed();
                }

                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->input('search') . '%');
                }

                if ($request->filled('makeId')) {
                    $query->where('makeId', $request->input('makeId'));
                }

                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                $stats = [
                    'total' => Models::withTrashed()->count(),
                    'public' => Models::where('status', true)->count(),
                    'private' => Models::where('status', false)->count(),
                    'trash' => Models::onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('model.append', ['data' => $data])->render(),
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

            return view('model.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('model.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'makeId' => 'required|uuid|exists:makes,uid',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/Model');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            Models::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'image' => $imagePath,
                'makeId' => $validated['makeId'],
                'status' => true,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Model created successfully.',
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
            $model = Models::where('uid', $uid)->firstOrFail();
            return view('model.edit', compact('model'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $model = Models::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'makeId' => 'required|uuid|exists:makes,uid',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = $model->image;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/Model');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            $model->update([
                'name' => $validated['name'],
                'image' => $imagePath,
                'makeId' => $validated['makeId'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Model updated successfully.',
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
            $model = Models::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($model->trashed()) {
                $model->restore();
                $message = 'Model restored successfully.';
            } else {
                $model->delete();
                $message = 'Model deleted successfully.';
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
            $model = Models::where('uid', $uid)->firstOrFail();
            $model->status = !$model->status;
            $model->save();

            return response()->json([
                'error' => false,
                'message' => 'Model status updated successfully.',
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
