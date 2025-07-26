<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\State;
use Illuminate\Http\Request;

class stateController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = State::with('country')->select('uid', 'name', 'countryId', 'code', 'created_at', 'deleted_at');

                if ($request->boolean('trashState')) {
                    $query = $query->onlyTrashed();
                }

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                }

                if ($request->filled('countryId')) {
                    $query = $query->where('countryId', $request->countryId);
                }

                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                $stats = [
                    'total' => State::withTrashed()->count(),
                    'trash' => State::onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('state.append', ['data' => $data])->render(),
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

            return view('state.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('state.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100|unique:states,name',
                'code' => 'required|string|max:10|unique:states,code',
                'countryId' => 'required|exists:countries,uid',
            ]);

            State::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'code' => $validated['code'],
                'countryId' => $validated['countryId'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'State created successfully.',
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
            $state = State::where('uid', $uid)->firstOrFail();
            return view('state.edit', compact('state'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $state = State::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100|unique:states,name,' . $state->stateId . ',stateId',
                'code' => 'required|string|max:10|unique:states,code,' . $state->stateId . ',stateId',
                'countryId' => 'required|exists:countries,uid',
            ]);

            $state->update([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'countryId' => $validated['countryId'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'State updated successfully.',
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
            $state = State::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($state->trashed()) {
                $state->restore();
                $message = 'State restored successfully.';
            } else {
                $state->delete();
                $message = 'State deleted successfully.';
            }

            return response()->json([
                'error' => false,
                'message' => $message,
            ]);
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
