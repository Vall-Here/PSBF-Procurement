<?php

// database/seeders/RKBSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RKB;
use App\Models\RKBItem;
use App\Models\User; // Pastikan untuk mengimpor model User jika belum dilakukan

class RKBSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID user pertama sebagai contoh
        $user = User::first(); // Pastikan ada minimal satu user di database

        // Membuat 10 data RKB dengan item-item terkait secara acak
        for ($i = 1; $i <= 10; $i++) {
            $rkb = RKB::create([
                'tahun_anggaran' => rand(2020, 2025), // tahun anggaran antara 2020 dan 2025
                'jumlah_anggaran' => rand(1000000, 10000000), // jumlah anggaran acak dalam IDR
                'user_id' => $user->id, // Assign user_id
            ]);

            // Menambahkan antara 1 hingga 5 item untuk setiap RKB
            $numItems = rand(1, 5);
            for ($j = 1; $j <= $numItems; $j++) {
                $rkb->items()->create([
                    'nama_barang' => $this->getRandomProductName(),
                    'satuan' => 'unit',
                    'rencana_pakai' => rand(10, 100), // rencana pakai acak antara 10 dan 100
                    'rencana_beli' => rand(10, 100), // rencana beli acak antara 10 dan 100
                    'mata_uang' => 'IDR',
                    'harga_satuan' => rand(100000, 1000000), // harga satuan acak dalam IDR
                    'keterangan' => 'Keterangan item ini',
                ]);
            }
        }
    }

    // Fungsi untuk mendapatkan nama barang secara acak (dummy)
    private function getRandomProductName()
    {
        $products = [
            'Komputer', 'Printer', 'Laptop', 'Scanner', 'Meja Kantor', 'Kursi Kantor',
            'Lemari Arsip', 'Proyektor', 'Telepon Kantor', 'Peralatan Kebersihan', 'Peralatan Presentasi',
        ];

        return $products[array_rand($products)];
    }
}
