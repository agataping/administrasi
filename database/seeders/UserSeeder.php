<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_user = [
            [
                'name' => 'kepaladinas',
                'username' => 'kepaladinas',
                'password' => Hash::make('kepaladinas'),
                'role' => 'pemimpin',
            ],
        ];

        foreach ($data_user as $user) {
            \App\Models\User::create($user);
        }
    }
}
