<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \DB::table('teachers')->insert([
        ['name' => 'Juan Dela Cruz', 'email' => 'juan@example.com'],
        ['name' => 'Maria Santos', 'email' => 'maria@example.com'],
    ]);
}

}
