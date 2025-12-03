<?php

namespace Database\Seeders;

use App\Models\ServiceInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceInfo::create(
            [
                'title' => 'Create Leads, Sell Products, Run Courses, and Create High Converting',
                'description' => 'Sales Funnels',
            ]
        );
    }
}
