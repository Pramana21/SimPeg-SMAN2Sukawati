<?php

namespace Database\Seeders;

use App\Models\KategoriKeuangan;
use Illuminate\Database\Seeder;

class KategoriKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Laporan Keuangan',
                'slug' => 'laporan',
            ],
            [
                'nama_kategori' => 'Gaji ASN',
                'slug' => 'gaji-asn',
            ],
            [
                'nama_kategori' => 'TPP ASN',
                'slug' => 'tpp-asn',
            ],
            [
                'nama_kategori' => 'TPG Guru',
                'slug' => 'tpg-guru',
            ],
        ];

        foreach ($kategori as $item) {
            KategoriKeuangan::firstOrCreate([
                'nama_kategori' => $item['nama_kategori'],
                'slug' => $item['slug'],
            ]);
        }
    }
}
