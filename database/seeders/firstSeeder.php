<?php

namespace Database\Seeders;

use App\Models\Afkir;
use App\Models\Ayam;
use App\Models\Breeding;
use App\Models\Commercial;
use App\Models\Kandang;
use App\Models\Machine;
use App\Models\Pakan;
use App\Models\Pen;
use App\Models\role;
use App\Models\User;
use App\Models\vaksin;
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
            'code_AYam' => 'KUB2',
            'strain_female' => 'KUB2',
            'strain_male' => 'KUB2',
        ]);
        Ayam::create([
            'code_AYam' => 'GAOK',
            'strain_female' => 'GAOK',
            'strain_male' => 'GAOK',
        ]);
        Ayam::create([
            'code_AYam' => 'SENTUL',
            'strain_female' => 'SENTUL',
            'strain_male' => 'SENTUL',
        ]);
        $kapasitas = [500, 1000, 2000]; // Daftar kapasitas

        for ($i = 1; $i <= 10; $i++) {
            // Menghitung index kapasitas yang akan digunakan berdasarkan $i
            $kapasitasIndex = $kapasitas[($i - 1) % count($kapasitas)];

            Machine::create([
                'machine_name' => 'Machine' . $i,
                'kapasitas' => $kapasitasIndex,
            ]);
        }

        Kandang::create([
            'nama_kandang' => 'BRD1',
            'lokasi_kandang' => 'cidokom',
            'jenis_kandang' => 'breeding',
        ]);
        Kandang::create([
            'nama_kandang' => 'CMR1',
            'lokasi_kandang' => 'cidokom',
            'jenis_kandang' => 'commerce',
        ]);
        Kandang::create([
            'nama_kandang' => 'AFK1',
            'lokasi_kandang' => 'cidokom',
            'jenis_kandang' => 'afkir',
        ]);

        for ($i = 1; $i <= 3; $i++) {
            // Loop untuk huruf A, B, C, D
            foreach (['A', 'B', 'C', 'D'] as $letter) {
                Pen::create([
                    'id_kandang' => 1,
                    'code_pen' => $i . $letter,
                ]);
            }
        }

        for ($i = 1; $i <= 10; $i++) {
            Pen::create([
                'id_kandang' => 2,
                'code_pen' => str_pad($i, 2, '0', STR_PAD_LEFT) . 'A',
            ]);
            Pen::create([
                'id_kandang' => 2,
                'code_pen' => str_pad($i, 2, '0', STR_PAD_LEFT) . 'B',
            ]);
        }

        Pen::create([
            'id_kandang' => 3,
            'code_pen' => 'AFKIR-BRD',
        ]);
        Pen::create([
            'id_kandang' => 3,
            'code_pen' => 'AFKIR-CMR',
        ]);
        Pen::create([
            'id_kandang' => 3,
            'code_pen' => 'KARANTINA-BRD',
        ]);
        Pen::create([
            'id_kandang' => 3,
            'code_pen' => 'KARANTINA-CMD',
        ]);

        // Breeding::create([
        //     'id_pen' => 1,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB',
        //     'jumlah_jantan' => 79,
        //     'jumlah_betina' => 286,
        //     'age' => '21',
        //     'inputBy' => 'user',
        // ]);
        // Breeding::create([
        //     'id_pen' => 2,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB',
        //     'jumlah_jantan' => 26,
        //     'jumlah_betina' => 121,
        //     'age' => '21',
        //     'inputBy' => 'user',
        // ]);
        // Breeding::create([
        //     'id_pen' => 3,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB',
        //     'jumlah_jantan' => 17,
        //     'jumlah_betina' => 129,
        //     'age' => '21',
        //     'inputBy' => 'user',
        // ]);
        // Breeding::create([
        //     'id_pen' => 4,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB',
        //     'jumlah_jantan' => 35,
        //     'jumlah_betina' => 260,
        //     'age' => '21',
        //     'inputBy' => 'user',
        // ]);
        // Breeding::create([
        //     'id_pen' => 5,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB',
        //     'jumlah_jantan' => 33,
        //     'jumlah_betina' => 161,
        //     'age' => '21',
        //     'inputBy' => 'user',
        // ]);
        // Breeding::create([
        //     'id_pen' => 6,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB',
        //     'jumlah_jantan' => 27,
        //     'jumlah_betina' => 212,
        //     'age' => '21',
        //     'inputBy' => 'user',
        // ]);
        // Breeding::create([
        //     'id_pen' => 7,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB',
        //     'jumlah_jantan' => 12,
        //     'jumlah_betina' => 99,
        //     'age' => '21',
        //     'inputBy' => 'user',
        // ]);
        // Commercial::create([
        //     'id_pen' => 8,
        //     'entry_population' => 1036,
        //     'age' => 0,
        //     'inputBy' => 'user',
        // ]);
        // Commercial::create([
        //     'id_pen' => 9,
        //     'entry_population' => 859,
        //     'age' => 0,
        //     'inputBy' => 'user',
        // ]);
        // Commercial::create([
        //     'id_pen' => 10,
        //     'entry_population' => 843,
        //     'age' => 0,
        //     'inputBy' => 'user',
        // ]);
        for ($i = 13; $i <= 23; $i++) {
            // Menghitung index kapasitas yang akan digunakan berdasarkan $i
            Commercial::create([
                    'id_pen' => $i,
                    'entry_population' => 100,
                    'age' => 0,
                    'inputBy' => 'user',
                ]);
        }
        Afkir::create([
            'id_pen' => 12,
            'male' => 7,
            'female' => 68,
        ]);
        Breeding::create([
            'id_pen' => 4,
            'code_ayam_jantan' => 'KUB',
            'code_ayam_betina' => 'KUB', // Assuming the same code for both
            'jumlah_jantan' => 89,
            'jumlah_betina' => 10, // Adjust this value as needed
            'cost_Total_induk' => (65000 * (99)),
            'cost_induk'=>65000,
            'age' => 1,
            'inputBy' => 'user', // Replace 'user' with the actual user identifier if needed
        ]);
        Breeding::create([
            'id_pen' => 3,
            'code_ayam_jantan' => 'KUB',
            'code_ayam_betina' => 'KUB', // Assuming the same code for both
            'jumlah_jantan' => 13,
            'jumlah_betina' => 101, // Adjust this value as needed
            'cost_Total_induk' => (65000 * (114)),
            'cost_induk'=>65000,
            'age' => 1,
            'inputBy' => 'user', // Replace 'user' with the actual user identifier if needed
        ]);
        Breeding::create([
            'id_pen' => 2,
            'code_ayam_jantan' => 'KUB',
            'code_ayam_betina' => 'KUB', // Assuming the same code for both
            'jumlah_jantan' => 192,
            'jumlah_betina' => 31, // Adjust this value as needed
            'cost_Total_induk' => (65000 * (223)),
            'cost_induk'=>65000,
            'age' => 1,
            'inputBy' => 'user', // Replace 'user' with the actual user identifier if needed
        ]);
        Breeding::create([
            'id_pen' => 1,
            'code_ayam_jantan' => 'KUB',
            'code_ayam_betina' => 'KUB', // Assuming the same code for both
            'jumlah_jantan' => 28,
            'jumlah_betina' => 192, // Adjust this value as needed
            'cost_Total_induk' => (65000 * (220)),
            'cost_induk'=>65000,
            'age' => 1,
            'inputBy' => 'user', // Replace 'user' with the actual user identifier if needed
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
            'qty' => 250,
            'harga' => 7700,
        ]);
        Pakan::create([
            'nama_pakan' => 'PHP-C',
            'qty' => 500,
            'harga' => 5500,
        ]);
        Pakan::create([
            'nama_pakan' => 'PAR-L',
            'qty' => 500,
            'harga' => 5500,
        ]);

        vaksin::create([
            'name' => 'Vaksin Avian Influenza',
            'deskripsi' => 'Vaksin untuk mencegah Avian Influenza pada ayam.',
        ]);
        vaksin::create([
            'name' => 'Vaksin Newcastle Disease',
            'deskripsi' => 'Vaksin untuk mencegah Newcastle Disease pada ayam.',
        ]);

        vaksin::create([
            'name' => 'Vaksin Marek\'s Disease',
            'deskripsi' => 'Vaksin untuk mencegah Marek\'s Disease pada ayam.',
        ]);
    }
}
