<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'code' => 'PLJ-001',
                'title' => 'Matematika Terapan SMK/MAK Kelas XI',
                'author' => 'Al Azhary Masta, Dicky Susanto',
                'publisher' => 'Pusat Perbukuan Kemendikbudristek',
                'year' => 2022,
                'category' => 'Pelajaran',
                'stock' => 15,
                'available_stock' => 13,
                'shelf_location' => 'Rak A-01',
                'cover_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=80',
                'description' => 'Buku teks utama mata pelajaran Matematika Terapan Kurikulum Merdeka untuk SMK/MAK Kelas XI.',
            ],
            [
                'code' => 'PLJ-002',
                'title' => 'Fisika Terapan SMK/MAK Kelas XII',
                'author' => 'Lia Laela Sarah, Irma Rahma Suwarma',
                'publisher' => 'Balai Pustaka & Kemdikbud',
                'year' => 2023,
                'category' => 'Pelajaran',
                'stock' => 12,
                'available_stock' => 10,
                'shelf_location' => 'Rak A-02',
                'cover_url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=500&auto=format&fit=crop&q=80',
                'description' => 'Membahas konsep mekanika teknik, fluida, kelistrikan dan kemagnetan untuk kejuruan teknik.',
            ],
            [
                'code' => 'PLJ-003',
                'title' => 'Dasar Desain Komunikasi Visual (DKV) SMK Kelas X',
                'author' => 'Maylinda Ambarwati, S.Sn.',
                'publisher' => 'Pusat Perbukuan Kemdikbud',
                'year' => 2022,
                'category' => 'Pelajaran',
                'stock' => 10,
                'available_stock' => 9,
                'shelf_location' => 'Rak A-03',
                'cover_url' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=500&auto=format&fit=crop&q=80',
                'description' => 'Membahas dasar-dasar tipografi, fotografi, ilustrasi vektor, dan prinsip desain grafis digital.',
            ],
            [
                'code' => 'FKS-001',
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'year' => 2005,
                'category' => 'Fiksi',
                'stock' => 8,
                'available_stock' => 6,
                'shelf_location' => 'Rak B-01',
                'cover_url' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&auto=format&fit=crop&q=80',
                'description' => 'Kisah inspiratif tentang sepuluh anak dari keluarga miskin yang bersekolah di sebuah sekolah Muhammadiyah di Belitung.',
            ],
            [
                'code' => 'FKS-002',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Lentera Dipantara',
                'year' => 2005,
                'category' => 'Fiksi',
                'stock' => 6,
                'available_stock' => 5,
                'shelf_location' => 'Rak B-02',
                'cover_url' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=500&auto=format&fit=crop&q=80',
                'description' => 'Kisah Minke di era kolonial Hindia Belanda dan perjuangan hak asasi kemanusiaan pribumi.',
            ],
            [
                'code' => 'TEK-001',
                'title' => 'Dasar Pemrograman Web Modern dengan PHP & MySQL',
                'author' => 'Budi Raharjo',
                'publisher' => 'Informatika Bandung',
                'year' => 2023,
                'category' => 'Teknologi',
                'stock' => 5,
                'available_stock' => 4,
                'shelf_location' => 'Rak C-01',
                'cover_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&auto=format&fit=crop&q=80',
                'description' => 'Panduan lengkap membuat aplikasi web dinamis dengan arsitektur MVC, basis data, dan keamanan web.',
            ],
            [
                'code' => 'TEK-002',
                'title' => 'Pengenalan Kecerdasan Buatan & Machine Learning',
                'author' => 'Suyanto, Ph.D.',
                'publisher' => 'Andi Offset',
                'year' => 2022,
                'category' => 'Teknologi',
                'stock' => 4,
                'available_stock' => 4,
                'shelf_location' => 'Rak C-02',
                'cover_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=500&auto=format&fit=crop&q=80',
                'description' => 'Konsep dasar algoritma AI, supervised learning, neural network, dan penerapannya di masa depan.',
            ],
            [
                'code' => 'SJR-001',
                'title' => 'Sejarah Nasional Indonesia: Masa Pergerakan & Kemerdekaan',
                'author' => 'Sartono Kartodirdjo',
                'publisher' => 'Balai Pustaka',
                'year' => 2019,
                'category' => 'Sejarah',
                'stock' => 7,
                'available_stock' => 7,
                'shelf_location' => 'Rak D-01',
                'cover_url' => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?w=500&auto=format&fit=crop&q=80',
                'description' => 'Dokumentasi komprehensif tentang lahirnya Budi Utomo, Sumpah Pemuda hingga Proklamasi 1945.',
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(['code' => $book['code']], $book);
        }
    }
}
