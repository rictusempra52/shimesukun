<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Company;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // 各会社に3つのマンションを作成
            for ($i = 1; $i <= 3; $i++) {
                Building::create([
                    'company_id' => $company->id,
                    'name' => $company->name . "マンション{$i}号",
                    'address' => "東京都" . $this->getWard($i) . "区サンプル{$i}-{$i}-{$i}",
                    'unit_count' => rand(20, 100),
                    'built_year' => rand(1990, 2020),
                ]);
            }
        }
    }

    /**
     * サンプル用の区名を取得
     */
    private function getWard(int $index): string
    {
        $wards = [
            '新宿', '渋谷', '港', '中央', '千代田',
            '文京', '台東', '墨田', '江東', '品川'
        ];

        return $wards[$index % count($wards)];
    }
}
