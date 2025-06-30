<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedConditions();
    }

    private function seedConditions(){

        $conditions = [
            'dyslexia' => 'Dyslexia',
            'attention_deficit' => 'Attention deficit',
            'autism' => 'Autism',
            'visual_impairment' => 'Visual impairment',
            'hearing_impairment' => 'Hearing impairment',
            'language_disorder' => 'Language disorder',
        ];

        $levels = ['low', 'mid', 'high'];

        $data = [];

        foreach ($conditions as $key => $condition) {
            foreach ($levels as $level) {
                $data[] = [
                    'type' => $key . '.' . $level,
                    'label' => $condition . ' ' .  strtoupper($level),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        $data[] = [
            'type' => 'User',
            'label' => 'Custom modifications',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('conditions')->insert($data);
    }
}
