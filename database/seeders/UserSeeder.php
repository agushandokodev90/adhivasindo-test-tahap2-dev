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
        $data = [
            [
                'nama' => 'Super Admin',
                'email' => 'super.admin@example.com',
                'password' => 'admin',
                'as'=>'admin'
            ]
        ];
        foreach ($data as $item) {
            User::create($item);
        }
    }
}
