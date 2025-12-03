<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['color_name' => 'Red',        'color_code' => '#FF0000', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'Green',      'color_code' => '#00FF00', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'Blue',       'color_code' => '#0000FF', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'Black',      'color_code' => '#000000', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'White',      'color_code' => '#FFFFFF', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'Yellow',     'color_code' => '#FFFF00', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'Orange',     'color_code' => '#FFA500', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'Purple',     'color_code' => '#800080', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'Pink',       'color_code' => '#FFC0CB', 'status' => 1, 'created_by' => 1],
            ['color_name' => 'Gray',       'color_code' => '#808080', 'status' => 1, 'created_by' => 1],
        ];

        DB::table('colors')->insert($colors);
    }
}
