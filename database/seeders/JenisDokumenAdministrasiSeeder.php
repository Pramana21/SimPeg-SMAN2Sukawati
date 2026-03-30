<?php

namespace Database\Seeders;

use App\Models\JenisDokumenAdministrasi;
use App\Models\KategoriAdministrasi;
use Illuminate\Database\Seeder;

class JenisDokumenAdministrasiSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriPegawai = KategoriAdministrasi::firstOrCreate([
            'nama_kategori' => 'Pegawai',
        ]);

        $kategoriSiswa = KategoriAdministrasi::firstOrCreate([
            'nama_kategori' => 'Siswa',
        ]);

        $mapping = [
            'Pegawai' => [
                'kategori_id' => $kategoriPegawai->id_kategori_administrasi,
                'jenis' => ['Absensi Pegawai', 'Laporan Piket'],
            ],
            'Siswa' => [
                'kategori_id' => $kategoriSiswa->id_kategori_administrasi,
                'jenis' => ['Absensi Siswa', 'Jurnal Kelas'],
            ],
        ];

        foreach ($mapping as $item) {
            foreach ($item['jenis'] as $namaJenis) {
                JenisDokumenAdministrasi::firstOrCreate([
                    'nama_jenis' => $namaJenis,
                    'id_kategori_administrasi' => $item['kategori_id'],
                ]);
            }
        }
    }
}
