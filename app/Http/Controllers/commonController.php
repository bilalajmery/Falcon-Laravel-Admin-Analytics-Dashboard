<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;

use App\Models\{Category, Type, Make, Role};

class commonController extends commonFunction
{
    public function category()
    {
        try {

            $category = Category::where('status', true)->get();
            return response()->json(['error' => false, 'category' => $category]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function type()
    {
        try {

            $type = Type::where('status', true)->get();
            return response()->json(['error' => false, 'type' => $type]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function make()
    {
        try {

            $make = Make::where('status', true)->get();
            return response()->json(['error' => false, 'make' => $make]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

    public function role()
    {
        try {

            $role = Role::where('status', true)->get();
            return response()->json(['error' => false, 'role' => $role]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }
}
