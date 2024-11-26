<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'title' => 'سایت دنا کالا',
            'description' => 'توضیحات سایت دنا کالا',
            'keywords' => 'کلمات کلیدی سایت دنا کالا',
            'logo' => null,
            'icon' => null,
        ]);
    }
}
