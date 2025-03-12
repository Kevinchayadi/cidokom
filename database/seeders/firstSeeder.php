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
use App\Models\vaksinType;
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
        role::create([
            'role' => 'analyst',
        ]);
        role::create([
            'role' => 'seller',
        ]);
        User::create([
            'name' => 'Admin',
            'username' => 'Admin',
            'password' => Hash::make('@dmin!2E'),
            'role_id' => '1',
        ]);
        User::create([
            'name' => 'user',
            'username' => 'user',
            'password' => Hash::make('User!2E4$'),
            'role_id' => '2',
        ]);
        User::create([
            'name' => 'kaila',
            'username' => 'kaila',
            'password' => Hash::make('K@ila!23'),
            'role_id' => '1',
        ]);
        User::create([
            'name' => 'willy',
            'username' => 'willy',
            'password' => Hash::make('w!lly1234$'),
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

        for ($i = 1; $i <= 3; $i++) {
            // Menghitung index kapasitas yang akan digunakan berdasarkan $i
            // $kapasitasIndex = $kapasitas[($i - 1) % count($kapasitas)];

            Machine::create([
                'machine_name' => 'Machine ' . $i,
                'kapasitas' => 1512,
            ]);
        }
        Machine::create([
            'machine_name' => 'Machine 4',
            'kapasitas' => 2160,
        ]);

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
                if($i ==1 ){
                    Pen::create([
                        'id_kandang' => 1,
                        'code_pen' => $i . $letter,
                        'status'=>'active',
                    ]);
                }else{
                    Pen::create([
                        'id_kandang' => 1,
                        'code_pen' => $i . $letter,
                    ]);
                }
                
            }
        }

        for ($i = 1; $i <= 10; $i++) {
            Pen::create([
                'id_kandang' => 2,
                'code_pen' => str_pad($i, 2, '0', STR_PAD_LEFT) . 'A',
                'status' => 'active',
            ]);
            Pen::create([
                'id_kandang' => 2,
                'code_pen' => str_pad($i, 2, '0', STR_PAD_LEFT) . 'B',
                'status' => 'active',
            ]);
        }

        Pen::create([
            'id_kandang' => 3,
            'code_pen' => 'AFKIR-BRD',
            'status' => 'inactive',
        ]);
        // Pen::create([
        //     'id_kandang' => 3,
        //     'code_pen' => 'AFKIR-CMR',
        // ]);
        Pen::create([
            'id_kandang' => 3,
            'code_pen' => 'KARANTINA-BRD',
            'status' => 'inactive',
        ]);
        Pen::create([
            'id_kandang' => 3,
            'code_pen' => 'KARANTINA-CMD',
            'status' => 'inactive',
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
        // for ($i = 13; $i <= 23; $i++) {
        //     // Menghitung index kapasitas yang akan digunakan berdasarkan $i
        //     Commercial::create([
        //             'id_pen' => $i,
        //             'entry_population' => 100,
        //             'age' => 0,
        //             'inputBy' => 'user',
        //         ]);
        // }
        // Afkir::create([
        //     'id_pen' => 12,
        //     'male' => 7,
        //     'female' => 68,
        // ]);
        // $breeding = Breeding::create([
        //     'id_pen' => 4,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB', // Assuming the same code for both
        //     'jumlah_jantan' => 89,
        //     'jumlah_betina' => 10, // Adjust this value as needed
        //     'cost_Total_induk' => (65000 * (99)),
        //     'cost_induk'=>65000,
        //     'age' => 1,
        //     'inputBy' => 'user', // Replace 'user' with the actual user identifier if needed
        // ]);
        
        // Breeding::create([
        //     'id_pen' => 3,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB', // Assuming the same code for both
        //     'jumlah_jantan' => 13,
        //     'jumlah_betina' => 101, // Adjust this value as needed
        //     'cost_Total_induk' => (65000 * (114)),
        //     'cost_induk'=>65000,
        //     'age' => 1,
        //     'inputBy' => 'user', // Replace 'user' with the actual user identifier if needed
        // ]);
        // Breeding::create([
        //     'id_pen' => 2,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB', // Assuming the same code for both
        //     'jumlah_jantan' => 192,
        //     'jumlah_betina' => 31, // Adjust this value as needed
        //     'cost_Total_induk' => (65000 * (223)),
        //     'cost_induk'=>65000,
        //     'age' => 1,
        //     'inputBy' => 'user', // Replace 'user' with the actual user identifier if needed
        // ]);
        // Breeding::create([
        //     'id_pen' => 1,
        //     'code_ayam_jantan' => 'KUB',
        //     'code_ayam_betina' => 'KUB', // Assuming the same code for both
        //     'jumlah_jantan' => 28,
        //     'jumlah_betina' => 192, // Adjust this value as needed
        //     'cost_Total_induk' => (65000 * (220)),
        //     'cost_induk'=>65000,
        //     'age' => 1,
        //     'inputBy' => 'user', // Replace 'user' with the actual user identifier if needed
        // ]);

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
            'qty' => 0.0,
            'harga' => 5500.0,
        ]);
        Pakan::create([
            'nama_pakan' => 'PHP-C',
            'qty' => 0.0,
            'harga' => 5500.0,
        ]);
        Pakan::create([
            'nama_pakan' => 'PAR-L',
            'qty' => 100.0,
            'harga' => 6600.0,
        ]);
        Pakan::create([
            'nama_pakan' => 'PAR-G',
            'qty' => 225.0,
            'harga' => 6800.0,
        ]);
        Pakan::create([
            'nama_pakan' => 'SB-100',
            'qty' => 125.0,
            'harga' => 7700.0,
        ]);
        Pakan::create([
            'nama_pakan' => 'B11A',
            'qty' => 800.0,
            'harga' => 8300.0,
        ]);


        $dataVaksin = [
           [ 'hari'=> '1', 'nama'=> 'MAREKS', 'type'=> 'BRD'],
           [ 'hari'=> '1', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '1', 'nama'=> 'ND AI KILLED', 'type'=> 'BRD'],
           [ 'hari'=> '1', 'nama'=> 'GUMBOPLEKS', 'type'=> 'BRD'],
           [ 'hari'=> '5', 'nama'=> 'KOKSI', 'type'=> 'BRD'],
           [ 'hari'=> '35', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '42', 'nama'=> 'AI SINGEL', 'type'=> 'BRD'],
           [ 'hari'=> '62', 'nama'=> 'CORYZA T SUSPENSION', 'type'=> 'BRD'],
           [ 'hari'=> '62', 'nama'=> 'ILT', 'type'=> 'BRD'],
           [ 'hari'=> '70', 'nama'=> 'POX', 'type'=> 'BRD'],
           [ 'hari'=> '77', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '91', 'nama'=> 'AI SINGEL', 'type'=> 'BRD'],
           [ 'hari'=> '112', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '147', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '203', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '231', 'nama'=> 'AI SINGEL', 'type'=> 'BRD'],
           [ 'hari'=> '245', 'nama'=> 'ND IB IBD', 'type'=> 'BRD'],
           [ 'hari'=> '287', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '329', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '357', 'nama'=> 'AI SINGEL', 'type'=> 'BRD'],
           [ 'hari'=> '371', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '413', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '441', 'nama'=> 'AI SINGEL', 'type'=> 'BRD'],
           [ 'hari'=> '455', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '497', 'nama'=> 'ND IB', 'type'=> 'BRD'],
           [ 'hari'=> '525', 'nama'=> 'ND IB IBD', 'type'=> 'BRD'],
           [ 'hari'=> '525', 'nama'=> 'AI SINGEL', 'type'=> 'BRD'],
           [ 'hari'=> '1', 'nama'=> 'ND IB', 'type'=> 'CMR'],
           [ 'hari'=> '7', 'nama'=> 'ND T-AI H5&H9', 'type'=> 'CMR'],
           [ 'hari'=> '14', 'nama'=> 'GUMBORO A', 'type'=> 'CMR'],
           [ 'hari'=> '28', 'nama'=> 'ND CLONE 45', 'type'=> 'CMR'],
           [ 'hari'=> '50', 'nama'=> 'ND CLONE 45', 'type'=> 'CMR']
        ];

        foreach ($dataVaksin as $vaksin) {
            vaksin::create($vaksin);
        }
        // $breeding->vaksin()->attach([1,2,3,4]);

        $vaksinType = [
            ['nama_vaksin'=> 'MAREKS', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'ND IB', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'ND AI KILLED', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'GUMBOPLEKS', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'KOKSI', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'AI SINGEL', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'CORYZA T SUSPENSION', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'ILT', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'POX', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'ND IB IBD', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'ND T-AI H5&H9', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'GUMBORO A', 'qty'=> 0, 'harga'=> 0],
            ['nama_vaksin'=> 'ND CLONE 45', 'qty'=> 0, 'harga'=> 0]
        ];
        
        foreach ($vaksinType as $vaksin) {
            vaksinType::create($vaksin);
        }

        // vaksin::create([
        //     'name' => 'Vaksin Avian Influenza',
        //     'deskripsi' => 'Vaksin untuk mencegah Avian Influenza pada ayam.',
        // ]);
        // vaksin::create([
        //     'name' => 'Vaksin Newcastle Disease',
        //     'deskripsi' => 'Vaksin untuk mencegah Newcastle Disease pada ayam.',
        // ]);

        // vaksin::create([
        //     'name' => 'Vaksin Marek\'s Disease',
        //     'deskripsi' => 'Vaksin untuk mencegah Marek\'s Disease pada ayam.',
        // ]);
    }
}
