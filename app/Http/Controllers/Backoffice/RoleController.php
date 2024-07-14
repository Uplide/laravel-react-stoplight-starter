<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\AdminRoleUpdateRequest;
use App\Http\Requests\Backoffice\RoleIndexRequest;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\Role;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @tags 😻 Dashboard > 5 > Role
 */
class RoleController extends Controller
{
    /**
     * List Role
     *
     * Bu servis rolleri listelemek için kullanılmaktadır. Tüm rolleri getirir
     *
     * @return Role[]
     */
    public function index(RoleIndexRequest $request): Collection|array
    {
        $admin = Auth::guard('admin-api')->user();
        $roles = [];
        if (@$admin->id) {
            $adminRoles = AdminRole::where("admin_id", $admin->id)->with("role")->get();
            foreach ($adminRoles as $role) {
                array_push($roles, @$role->role->name);
            }
        }

        $search = @$request->search;
        return ["data" => Role::where(function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }
        })
            // ->whereIn("name", $roles)
            ->get(["id", "name", "description"])];
    }
}
