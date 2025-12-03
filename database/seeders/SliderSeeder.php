<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slider::create(
            [
                'title' => 'Create Leads, Sell Products, Run Courses, and Create High Converting',
                'title_end' => 'Sales Funnels',
                'bio' => 'All Without Coding!',
                'bg_color' => '#111827',
                'button_details' => "From Grabbing Visitors' Attention To Converting Them Into Leads And Sales…",
                'button_text' => 'Get Started With Founder King',
                'button_url' => '#',
                'video_url' => 'https://www.youtube.com/watch?v=W6BlwzAhJ88',
            ]);
    }
}
