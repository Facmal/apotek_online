<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'jabatan' => 'admin'
            ],
            [
                'name' => 'Apoteker',
                'email' => 'apoteker@example.com',
                'password' => bcrypt('password'),
                'jabatan' => 'apoteker'
            ],
            [
                'name' => 'Karyawan',
                'email' => 'karyawan@example.com',
                'password' => bcrypt('password'),
                'jabatan' => 'karyawan'
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@example.com',
                'password' => bcrypt('password'),
                'jabatan' => 'kasir'
            ],
            [
                'name' => 'Pemilik',
                'email' => 'pemilik@example.com',
                'password' => bcrypt('password'),
                'jabatan' => 'pemilik'
            ]
        ];
        foreach ($userData as $user) {
            \App\Models\User::create($user);
        }
    }
}
