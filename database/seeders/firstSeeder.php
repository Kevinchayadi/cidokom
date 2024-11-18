<?php

namespace Database\Seeders;

use App\Models\Ayam;
use App\Models\Kandang;
use App\Models\Machine;
use App\Models\Pakan;
use App\Models\Pen;
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
        Machine::create([
            'machine_name' => 'Machine1'
        ]);
        Machine::create([
            'machine_name' => 'Machine2'
        ]);
        Machine::create([
            'machine_name' => 'Machine3'
        ]);
        Machine::create([
            'machine_name' => 'Machine4'
        ]);
        Machine::create([
            'machine_name' => 'Machine5'
        ]);
        Kandang::create([
            'nama_kandang' => 'BRD1',
            'lokasi_kandang' => 'cidokom',
            'jenis_kandang' => 'breeding' 
        ]);
        Kandang::create([
            'nama_kandang' => 'CMR1',
            'lokasi_kandang' => 'cidokom',
            'jenis_kandang' => 'commerce' 
        ]);
        // Kandang::create([
        //     'nama_kandang' => 'BRD2',
        //     'jenis_kandang' => 'breeding' 
        // ]);
        // Kandang::create([
        //     'nama_kandang' => 'CMR2',
        //     'jenis_kandang' => 'commerce' 
        // ]);
        // Pen::create([
        //     'id_kandang'=> 1,
        //     'code_pen' => '1A'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 1,
        //     'code_pen' => '1B'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 1,
        //     'code_pen' => '1C'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 1,
        //     'code_pen' => '2A'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 1,
        //     'code_pen' => '2B'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 2,
        //     'code_pen' => '1A'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 2,
        //     'code_pen' => '1B'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 2,
        //     'code_pen' => '2A'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 2,
        //     'code_pen' => '2B'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 2,
        //     'code_pen' => '3A'
        // ]);
        // Pen::create([
        //     'id_kandang'=> 2,
        //     'code_pen' => '3B'
        // ]);
        Pakan::create([
            'nama_pakan' => 'GF-11',
            'qty' => 1000,
            'harga' => 10000
        ]);
        Pakan::create([
            'nama_pakan' => 'GF-12',
            'qty' => 250,
            'harga' => 7000
        ]);
    }
}
