<?php

namespace Database\Seeders;

use App\Models\Ayam;
use App\Models\role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class firstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        role::create([
            'role' => 'Admin',
        ]);
        role::create([
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Admin',
            'username' => 'Admin',
            'password' => Hash::make('admin'),
            'role_id' => '1',
        ]);

        User::create([
            'name' => 'user',
            'username' => 'user',
            'password' => Hash::make('user'),
            'role_id' => '2',
        ]);

        Ayam::create([
            'code_AYam' =>'KUB2',
            'strain_female'=>'KUB2',
            'strain_male'=>'KUB2',
        ]);
        Ayam::create([
            'code_AYam' =>'GAOK',
            'strain_female'=>'GAOK',
            'strain_male'=>'GAOK',
        ]);
        Ayam::create([
            'code_AYam' =>'SENTUL',
            'strain_female'=>'SENTUL',
            'strain_male'=>'SENTUL',
        ]);
        
    }
}
