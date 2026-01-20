<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Operator',
            'email' => 'operator@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $question = Question::create([
            'question' => 'Sebutkan Alat Pelindung Diri (APD) wajib saat memasuki area kilang!',
            'is_active' => true,
        ]);

        $question->answers()->createMany([
            [
                'answer_text' => 'HELM SAFETY',
                'point' => 35,
                'order_rank' => 1,
                'is_revealed' => false
            ],
            [
                'answer_text' => 'SEPATU SAFETY',
                'point' => 25,
                'order_rank' => 2,
                'is_revealed' => false
            ],
            [
                'answer_text' => 'WEARPACK / COVERALL',
                'point' => 20,
                'order_rank' => 3,
                'is_revealed' => false
            ],
            [
                'answer_text' => 'KACAMATA / GOGGLES',
                'point' => 10,
                'order_rank' => 4,
                'is_revealed' => false
            ],
            [
                'answer_text' => 'SARUNG TANGAN',
                'point' => 10,
                'order_rank' => 5,
                'is_revealed' => false
            ],
        ]);

        $q2 = Question::create([
            'question' => 'Apa penyebab utama kebakaran di area kerja?',
            'is_active' => false,
        ]);

        $q2->answers()->createMany([
            ['answer_text' => 'KORSLETING LISTRIK', 'point' => 40, 'order_rank' => 1],
            ['answer_text' => 'PUNTUNG ROKOK', 'point' => 30, 'order_rank' => 2],
            ['answer_text' => 'BAHAN MUDAH TERBAKAR', 'point' => 20, 'order_rank' => 3],
            ['answer_text' => 'HUMAN ERROR', 'point' => 10, 'order_rank' => 4],
        ]);
    }
}
