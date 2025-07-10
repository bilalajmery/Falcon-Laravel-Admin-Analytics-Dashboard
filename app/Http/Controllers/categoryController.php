<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Category::select('uid', 'name', 'image', 'status', 'created_at', 'deleted_at');

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
                    'total' => Category::withTrashed()->count(),
                    'public' => Category::where('status', true)->count(),
                    'private' => Category::where('status', false)->count(),
                    'trash' => Category::onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('category.append', ['data' => $data])->render(),
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

            return view('category.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('category.create');
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
                $response = $this->storeImage($request->file('image'), 'uploads/category');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            Category::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'image' => $imagePath,
                'status' => true,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Category created successfully.',
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
            $category = Category::where('uid', $uid)->firstOrFail();
            return view('category.edit', compact('category'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $category = Category::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = $category->image;
            if ($request->hasFile('image')) {
                $response = $this->storeImage($request->file('image'), 'uploads/category');

                if (!empty($response['error'])) {
                    return response()->json([
                        'error' => true,
                        'message' => $response['message'],
                    ], 422);
                }

                $imagePath = $response['path'];
            }

            $category->update([
                'name' => $validated['name'],
                'image' => $imagePath,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Category updated successfully.',
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
            $category = Category::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($category->trashed()) {
                $category->restore();
                $message = 'Category restored successfully.';
            } else {
                $category->delete();
                $message = 'Category deleted successfully.';
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
            $category = Category::where('uid', $uid)->firstOrFail();
            $category->status = !$category->status;
            $category->save();

            return response()->json([
                'error' => false,
                'message' => 'Category status updated successfully.',
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
