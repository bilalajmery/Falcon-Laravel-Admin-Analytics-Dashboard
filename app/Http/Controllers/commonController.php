<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;

use App\Models\{Category, Type};

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
}
