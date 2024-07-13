<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\AdminRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

define('ADMIN_PASSWORD', '123456');

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->items() as $item) {
            $data = Admin::where("email", $item["email"])->first();

            if (!$data) {
                $data = Admin::create([
                    'name' => $item["name"],
                    'surname' => $item["surname"],
                    'email' => $item["email"],
                    'password' => Hash::make($item["password"]),
                ]);

                $this->assignRolesToAdmin($data);
            }
        }
    }

    private function items()
    {
        return [
            [
                'name' => 'Royalmind',
                'surname' => 'App',
                'email' => 'dev@uplidelaravel.com',
                'password' => ADMIN_PASSWORD,
            ],
            [
                'name' => 'Cihan',
                'surname' => 'TAYLAN',
                'email' => 'cihan.taylan@uplide.com',
                'password' => ADMIN_PASSWORD,
            ],
            [
                'name' => 'Vedat',
                'surname' => 'Şen',
                'email' => 'vedat.sen@uplide.com.com',
                'password' => ADMIN_PASSWORD,
            ]
        ];
    }

    private function assignRolesToAdmin($admin)
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            AdminRole::firstOrCreate([
                'admin_id' => $admin->id,
                'role_id' => $role->id,
            ]);
        }
    }
}
