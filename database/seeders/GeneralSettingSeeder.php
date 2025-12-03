<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSetting::create([
            'name'=>'Founder King',
            'email'=>'support@founderking.com',
            'phone'=>'01777777777',
            'meta_description'=>'Founder King',
            'meta_keywords'=>'Founder King',
            'primary_color'=>'#10B981',
            'secondary_color'=>'#6366F1',
            'primary_hover_color'=>'#059669',
            'secondary_hover_color'=>'#4F46E5',
        ]);
    }
}
