<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        \App\Models\User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Insert Kategori Event
        $category = \App\Models\Category::create([
            'name' => 'Seminar',
            'slug' => 'seminar',
        ]);

        $category2 = \App\Models\Category::firstOrCreate([
            'name' => 'Konser',
            'slug' => 'konser',
        ]);

        $category3 = \App\Models\Category::firstOrCreate([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        // 3. Insert Sampel Events
        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title' => 'Jazz Night 2026',
            'description' => 'Nikmati malam dengan alunan musik jazz.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category->id,
            'title' => 'Seminar Cyber Security',
            'description' => 'Belajar keamanan siber bersama praktisi.',
            'date' => '2026-05-05 10:00:00',
            'location' => 'Inkubator Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-2.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category->id,
            'title' => 'AI Future Tech Summit',
            'description' => 'Membahas perkembangan AI masa depan.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Cinema Unit 6',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-3.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title' => 'Campus Music Fest',
            'description' => 'Festival musik kampus dengan guest star.',
            'date' => '2026-06-15 18:00:00',
            'location' => 'Lapangan Amikom',
            'price' => 75000,
            'stock' => 200,
            'poster_path' => 'posters/event-4.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title' => 'Workshop UI/UX Design',
            'description' => 'Pelatihan desain aplikasi modern.',
            'date' => '2026-06-20 09:00:00',
            'location' => 'Lab Multimedia',
            'price' => 30000,
            'stock' => 50,
            'poster_path' => 'posters/event-5.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title' => 'Workshop Public Speaking',
            'description' => 'Latihan berbicara percaya diri di depan umum.',
            'date' => '2026-06-25 08:00:00',
            'location' => 'Ruang Seminar',
            'price' => 25000,
            'stock' => 60,
            'poster_path' => 'posters/event-6.png',
        ]);
    }
}