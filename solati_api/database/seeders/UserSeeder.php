<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'name' => 'Test Api',
                'nick' => 'pruebas',
                'email' => 'testsolati@mail.com',
                'password' => '$2y$10$/OWWysaId8ZtLEzI/ucCTOFUaF01FeDtnntHwoLdoavLp.v7qVNmO',
            ],
            [
                'name' => 'Test Api',
                'nick' => 'pruebas',
                'email' => 'testsolati@mail.com',
                'password' => '$2y$10$/OWWysaId8ZtLEzI/ucCTOFUaF01FeDtnntHwoLdoavLp.v7qVNmO',
                'email_verified_at' => '2023-09-26 02:57:06',
                'created_at' => '2023-09-26 02:57:06',
                'updated_at' => '2023-09-26 02:57:06'
             ]
        );
    }
}
