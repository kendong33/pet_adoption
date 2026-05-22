<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Admin Account ──────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // ── Sample Adopter Account ─────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'adopter@example.com'],
            [
                'name'     => 'Sample Adopter',
                'password' => Hash::make('password'),
                'role'     => 'adopter',
            ]
        );

        // ── Sample Pets ────────────────────────────────────────────────
        $pets = [
            [
                'name'          => 'Buddy',
                'category'      => 'Dog',
                'breed'         => 'Labrador Retriever',
                'age'           => 2,
                'gender'        => 'Male',
                'health_status' => 'Vaccinated & Neutered',
                'description'   => 'Buddy is a friendly and energetic Labrador who loves to play fetch and cuddle.',
                'image'         => null,
                'status'        => 'Available',
            ],
            [
                'name'          => 'Luna',
                'category'      => 'Cat',
                'breed'         => 'Persian',
                'age'           => 3,
                'gender'        => 'Female',
                'health_status' => 'Vaccinated & Spayed',
                'description'   => 'Luna is a calm and gentle Persian cat who enjoys quiet evenings and lap cuddles.',
                'image'         => null,
                'status'        => 'Available',
            ],
            [
                'name'          => 'Max',
                'category'      => 'Dog',
                'breed'         => 'German Shepherd',
                'age'           => 4,
                'gender'        => 'Male',
                'health_status' => 'Healthy',
                'description'   => 'Max is a loyal and intelligent German Shepherd, great with families.',
                'image'         => null,
                'status'        => 'Adopted',
            ],
            [
                'name'          => 'Mochi',
                'category'      => 'Rabbit',
                'breed'         => 'Holland Lop',
                'age'           => 1,
                'gender'        => 'Female',
                'health_status' => 'Healthy',
                'description'   => 'Mochi is an adorable Holland Lop rabbit, gentle and easy to care for.',
                'image'         => null,
                'status'        => 'Available',
            ],
            [
                'name'          => 'Charlie',
                'category'      => 'Dog',
                'breed'         => 'Beagle',
                'age'           => 5,
                'gender'        => 'Male',
                'health_status' => 'Vaccinated',
                'description'   => 'Charlie is a playful Beagle who loves long walks and treats.',
                'image'         => null,
                'status'        => 'Archived',
            ],
        ];

        foreach ($pets as $pet) {
            Pet::create($pet);
        }
    }
}
