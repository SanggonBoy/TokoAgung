<?php

namespace Database\Seeders;

use App\Models\coa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $dataCoa = [
            ['kode_akun' => '100', 'nama_akun' => 'Kas'],
            ['kode_akun' => '130', 'nama_akun' => 'Persediaan Barang Dagang'],
            ['kode_akun' => '100', 'nama_akun' => 'Beban Gaji'],
            ['kode_akun' => '110', 'nama_akun' => 'Beban Listrik dan Air'],
            ['kode_akun' => '120', 'nama_akun' => 'Beban Sewa Toko'],
            ['kode_akun' => '130', 'nama_akun' => 'Beban Telepon dan Internet'],
            ['kode_akun' => '140', 'nama_akun' => 'Beban Penyusutan'],
            ['kode_akun' => '150', 'nama_akun' => 'Beban Lain-lain'],
        ];

        coa::insert($dataCoa);
    }
}
