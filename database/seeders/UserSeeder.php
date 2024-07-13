<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

define('USER_PASSWORD', '123456');

class UserSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->items() as $item) {
            $user = User::where("email", $item["email"])->first();

            if (!$user) {
                User::create([
                    'name' => $item["name"],
                    'surname' => $item["surname"],
                    'email' => $item["email"],
                    'phone' => $item["phone"],
                    'phone_code' => $item["phone_code"],
                    'password' => Hash::make($item["password"]),
                ]);
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
                'phone' => '905326767231',
                'phone_code' => '+90',
                'password' => USER_PASSWORD,
            ],
            [
                'name' => 'Vedat',
                'surname' => 'Şen',
                'email' => 'vedat.sen@uplide.com',
                'phone' => '905326767239',
                'phone_code' => '+90',
                'password' => USER_PASSWORD,
            ],
            [
                'name' => 'Cihan',
                'surname' => 'Taylan',
                'email' => 'cihan.taylan@uplide.com',
                'phone' => '905326767238',
                'phone_code' => '+90',
                'password' => USER_PASSWORD,
            ],
        ];
    }
}
