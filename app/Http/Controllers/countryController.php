<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;
use App\Models\Country;
use Illuminate\Http\Request;

class countryController extends commonFunction
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Country::select('uid', 'name', 'code', 'created_at', 'deleted_at');

                if ($request->boolean('trashCountry')) {
                    $query = $query->onlyTrashed();
                }

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                }

                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $data = $query->orderBy('created_at', $request->input('orderBy', 'DESC'))
                    ->paginate($perPage, ['*'], 'page', $page);

                $stats = [
                    'total' => Country::withTrashed()->count(),
                    'trash' => Country::onlyTrashed()->count(),
                ];

                return response()->json([
                    'data' => view('country.append', ['data' => $data])->render(),
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

            return view('country.index');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function create()
    {
        try {
            return view('country.create');
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100|unique:countries,name',
                'code' => 'required|string|max:10|unique:countries,code',
            ]);

            Country::create([
                'uid' => (string) $this->uIdGenerate(),
                'name' => $validated['name'],
                'code' => $validated['code'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Country created successfully.',
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
            $country = Country::where('uid', $uid)->firstOrFail();
            return view('country.edit', compact('country'));
        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function update(Request $request, string $uid)
    {
        try {
            $country = Country::where('uid', $uid)->firstOrFail();

            $validated = $request->validate([
                'name' => 'required|string|max:100|unique:countries,name,' . $country->countryId . ',countryId',
                'code' => 'required|string|max:10|unique:countries,code,' . $country->countryId . ',countryId',
            ]);

            $country->update([
                'name' => $validated['name'],
                'code' => $validated['code'],
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Country updated successfully.',
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
            $country = Country::withTrashed()->where('uid', $uid)->firstOrFail();

            if ($country->trashed()) {
                $country->restore();
                $message = 'Country restored successfully.';
            } else {
                $country->delete();
                $message = 'Country deleted successfully.';
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
