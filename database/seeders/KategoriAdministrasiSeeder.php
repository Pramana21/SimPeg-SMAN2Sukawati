<?php

namespace Database\Seeders;

use App\Models\KategoriAdministrasi;
use Illuminate\Database\Seeder;

class KategoriAdministrasiSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Pegawai', 'Siswa'] as $namaKategori) {
            KategoriAdministrasi::firstOrCreate([
                'nama_kategori' => $namaKategori,
            ]);
        }
    }
}
