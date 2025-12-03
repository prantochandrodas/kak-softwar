<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create(
            [

                'email' => 'admin@gmail.com',
                'whatsapp_no' => '+8801830701422',
                'secondary_whatsapp_no' => '+8801857675727',
                'telegram_no' => '+8801857675727',
            ],
        );
    }
}
