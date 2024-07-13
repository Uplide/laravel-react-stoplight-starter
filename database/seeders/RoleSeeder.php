<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Enums\RoleTypes;

class RoleSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->items() as $item) {
            if (!@Role::where("name", $item["name"])->first()->id) {
                Role::create([
                    'name' => $item["name"],
                    'description' => $item["description"]
                ]);
            }
        }
    }

    private function items()
    {
        return [
            // Admin Management Roles
            [
                "name" => RoleTypes::ADMIN_VIEW,
                "description" => "View Admins"
            ],
            [
                "name" => RoleTypes::ADMIN_CREATE,
                "description" => "Create Admin"
            ],
            [
                "name" => RoleTypes::ADMIN_DELETE,
                "description" => "Delete Admin"
            ],
            [
                "name" => RoleTypes::ADMIN_UPDATE,
                "description" => "Update Admin"
            ],
            [
                "name" => RoleTypes::ADMIN_ROLE,
                "description" => "Update Admin Role"
            ],
            // User Management Roles
            [
                "name" => RoleTypes::USER_VIEW,
                "description" => "View Users"
            ],
            [
                "name" => RoleTypes::USER_CREATE,
                "description" => "Create User"
            ],
            [
                "name" => RoleTypes::USER_DELETE,
                "description" => "Delete User"
            ],
            [
                "name" => RoleTypes::USER_UPDATE,
                "description" => "User Update"
            ],
        ];
    }
}
