<?php


namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;


class CountrySeeder extends Seeder
{
    public function run()
    {
        foreach ($this->items() as $item) {
            $data = Country::where("id", $item["id"])->first();

            if (!$data) {
                Country::create([
                    'id' => $item["id"],
                    'binary_code' => $item["binary_code"],
                    'triple_code' => $item["triple_code"],
                    'country_name' => $item["country_name"],
                    'phone_code' => $item["phone_code"],
                    'status' => $item["status"],
                ]);
            }
        }
    }

    private function items()
    {
        return [
            [
                "id" => 1,
                "binary_code" => 'TR',
                "triple_code" => 'TUR',
                "country_name" => 'Türkiye',
                "phone_code" => '90',
                "status" => 1,
            ]
        ];
    }
}
