<?php

namespace App\Http\Controllers;

use App\Http\Controllers\commonFunction;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Make;
use App\Models\Role;
use App\Models\Type;
use Illuminate\Support\Facades\Session;

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

    public function sidebar()
    {
        try {
            $adminId = Session::get('adminSession.adminId');

            $admin = Admin::select('adminId', 'type', 'roleId')
                ->with(['role:uid,permission']) // eager load only needed columns
                ->where('adminId', $adminId)
                ->first();

            return response()->json(['error' => false, 'admin' => $admin]);

        } catch (\Throwable $th) {
            return $this->tryCatchResponse($th);
        }
    }

}
