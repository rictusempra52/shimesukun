<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テスト用管理会社の作成
        Company::create([
            'name' => '分識管理株式会社',
            'address' => '東京都千代田区丸の内1-1-1',
        ]);

        Company::create([
            'name' => '住宅管理サービス株式会社',
            'address' => '東京都新宿区新宿2-2-2',
        ]);

        Company::create([
            'name' => 'プロパティマネジメント株式会社',
            'address' => '東京都渋谷区渋谷3-3-3',
        ]);
    }
}
