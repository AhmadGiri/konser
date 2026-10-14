<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'Konser Musik Nusantara Fest',
                'category' => 'Musik',
                'ticket_price' => 50000,
                'description' => 'A live music concert featuring popular bands.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Festival Makanan Nusantara',
                'category' => 'Festival',
                'ticket_price' => 30000,
                'description' => 'A festival showcasing a variety of delicious foods.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seminar Teknologi Terkini',
                'category' => 'Seminar',
                'ticket_price' => 20000,
                'description' => 'A seminar discussing the latest trends in technology.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
