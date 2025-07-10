<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class subCategoryController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = SubCategory::with('category')->select('uid', 'name', 'image', 'status', 'created_at', 'deleted_at', 'categoryId');

                if ($request->boolean('trashCategory')) {
                    $query = $query->onlyTrashed();
                }

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $query->where('name', 'like', "%{$search}%");
                }

                if ($request->filled('categoryId')) {
                    $query->where('categoryId', $request->input('categoryId'));
                }

                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                $stats = [
                    'total' => SubCategory::withTrashed()->count(),
                    'public' => SubCategory::where('status', true)->count(),
                    'private' => SubCategory::where('status', false)->count(),
                    'trash' => SubCategory::onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('subCategory.append', ['data' => $data])->render(),
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

            return view('subCategory.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('subCategory.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'categoryId' => 'required|uuid|exists:categories,uid',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/subCategory');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            SubCategory::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'image' => $imagePath,
                'categoryId' => $validated['categoryId'],
                'status' => true,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'SubCategory created successfully.',
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
            $subCategory = SubCategory::where('uid', $uid)->firstOrFail();
            return view('subCategory.edit', compact('subCategory'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $subCategory = SubCategory::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'categoryId' => 'required|uuid|exists:categories,uid',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = $subCategory->image;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/subCategory');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            $subCategory->update([
                'name' => $validated['name'],
                'image' => $imagePath,
                'categoryId' => $validated['categoryId'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'SubCategory updated successfully.',
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
            $subCategory = SubCategory::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($subCategory->trashed()) {
                $subCategory->restore();
                $message = 'SubCategory restored successfully.';
            } else {
                $subCategory->delete();
                $message = 'SubCategory deleted successfully.';
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
            $subCategory = SubCategory::where('uid', $uid)->firstOrFail();
            $subCategory->status = !$subCategory->status;
            $subCategory->save();

            return response()->json([
                'error' => false,
                'message' => 'SubCategory status updated successfully.',
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
