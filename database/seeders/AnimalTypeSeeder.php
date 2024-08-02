<?php

namespace Database\Seeders;

use App\Models\AnimalType;
use Illuminate\Database\Seeder;

class AnimalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'description' => 'Gato',
            ],
            [
                'description' => 'Cachorro',
            ],
            [
                'description' => 'Pássaro',
            ],
        ];
        foreach($types as $type) {
            AnimalType::firstOrCreate($type);
        }
    }
}
