<?php

namespace App\Http\Middleware;

use App\Http\Controllers\commonFunction;
use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class accessManagement extends commonFunction
{
    public function handle(Request $request, Closure $next): Response
    {
        $currentRoute = Route::current()?->uri();

        // ✅ Whitelisted routes: allowed to all logged-in admins
        $whitelistedRoutes = [
            'setting',
            'setting/personal',
            'setting/twoStepVerification',
            'setting/password',
            'setting/profile',
            'setting/cover',
            'setting/accountDelete',
        ];

        if (in_array($currentRoute, $whitelistedRoutes)) {
            return $next($request);
        }

        // ✅ Get current admin from session
        $adminId = Session::get('adminSession.adminId');
        $admin = Admin::with('role')->find($adminId);

        if (!$admin) {
            return redirect('/404');
        }

        // ✅ Give full access to ADMIN type
        if ($admin->type === 'ADMIN') {
            return $next($request);
        }

        // 🔒 Restricted to ADMIN only
        $adminOnlyRoutes = [
            'admin', 'admin/create', 'admin/{admin}/edit', 'admin/{admin}', 'admin/{uid}/status',
            'role', 'role/create', 'role/{role}/edit', 'role/{role}', 'role/{uid}/status',
            'role/permission/{uid}', 'role/permission',
            'employee', 'employee/create', 'employee/{employee}/edit', 'employee/{employee}', 'employee/{uid}/status',
        ];

        if (in_array($currentRoute, $adminOnlyRoutes)) {
            return $this->denyAccess();
        }

        // 🔍 Get relative route and validate against role permissions
        $relativeRoute = $this->getRelativeRoute($currentRoute);
        if ($relativeRoute === '404') {
            return redirect('/404');
        }

        $permissions = json_decode($admin->role->permission ?? '{}', true);
        if (!empty($permissions[$relativeRoute])) {
            return $next($request);
        }

        return $this->denyAccess();
    }

    /**
     * Maps a full route URI to a permission key.
     */
    private function getRelativeRoute(string $uri): string
    {
        $map = [
            'home' => 'home',

            'category' => 'category',
            'category/create' => 'category',
            'category/{category}/edit' => 'category',
            'category/{category}' => 'category',
            'category/{uid}/status' => 'category',

            'subCategory' => 'subCategory',
            'subCategory/create' => 'subCategory',
            'subCategory/{subCategory}/edit' => 'subCategory',
            'subCategory/{subCategory}' => 'subCategory',
            'subCategory/{uid}/status' => 'subCategory',

            'type' => 'type',
            'type/create' => 'type',
            'type/{type}/edit' => 'type',
            'type/{type}' => 'type',
            'type/{uid}/status' => 'type',

            'subType' => 'subType',
            'subType/create' => 'subType',
            'subType/{subType}/edit' => 'subType',
            'subType/{subType}' => 'subType',
            'subType/{uid}/status' => 'subType',

            'make' => 'make',
            'make/create' => 'make',
            'make/{make}/edit' => 'make',
            'make/{make}' => 'make',
            'make/{uid}/status' => 'make',

            'model' => 'model',
            'model/create' => 'model',
            'model/{model}/edit' => 'model',
            'model/{model}' => 'model',
            'model/{uid}/status' => 'model',
        ];

        return $map[$uri] ?? '404';
    }

    private function denyAccess(): Response
    {
        return response()->view('access.index', [], Response::HTTP_FORBIDDEN);
    }
}
