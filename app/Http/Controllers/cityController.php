<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\{City, Country};
use App\Models\State;
use Illuminate\Http\Request;

class cityController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = City::with(['country', 'state'])->select('uid', 'name', 'stateId', 'countryId', 'created_at', 'deleted_at');

                if ($request->boolean('trashCity')) {
                    $query = $query->onlyTrashed();
                }

                if ($request->filled('stateId')) {
                    $query = $query->where('stateId', $request->stateId);
                }

                if ($request->filled('countryId')) {
                    $query = $query->where('countryId', $request->countryId);
                }

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                }

                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                $stats = [
                    'total' => City::withTrashed()->count(),
                    'trash' => City::onlyTrashed()->count(),
                ];
                // dd($data);
                return response()->json([
                    'data' => view('city.append', ['data' => $data])->render(),
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
            return view('city.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('city.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            // Step 1: Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'stateId' => 'required|exists:states,uid',
                'countryId' => 'required|uuid|exists:countries,uid',
            ]);

            // Step 2: Check if city already exists with same name in the state and country (case-insensitive)
            $exists = City::where('stateId', $validated['stateId'])
                ->where('countryId', $validated['countryId'])
                ->whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
                ->exists();

            if ($exists) {
                return response()->json([
                    'error' => true,
                    'message' => 'This city already exists in the selected state and country.',
                ], 409);
            }

            // Step 3: Create city
            City::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'stateId' => $validated['stateId'],
                'countryId' => $validated['countryId'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'City created successfully.',
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
            $city = City::where('uid', $uid)->firstOrFail();
            return view('city.edit', compact('city'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $city = City::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'stateId' => 'required|exists:states,uid',
                'countryId' => 'required|uuid|exists:countries,uid',
            ]);

            // Check if city name already exists in the same state and country (excluding current city)
            $exists = City::where('stateId', $validated['stateId'])
                ->where('countryId', $validated['countryId'])
                ->whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
                ->where('cityId', '!=', $city->cityId)
                ->exists();

            if ($exists) {
                return response()->json([
                    'error' => true,
                    'message' => 'This city name already exists in the selected state and country.',
                ], 409);
            }

            $city->update([
                'name' => $validated['name'],
                'stateId' => $validated['stateId'],
                'countryId' => $validated['countryId'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'City updated successfully.',
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
            $city = City::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($city->trashed()) {
                $city->restore();
                $message = 'City restored successfully.';
            } else {
                $city->delete();
                $message = 'City deleted successfully.';
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
