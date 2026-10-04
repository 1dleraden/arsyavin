<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $book1 = Book::where('code', 'PLJ-001')->first();
        $book2 = Book::where('code', 'PLJ-002')->first();
        $book3 = Book::where('code', 'FKS-001')->first();
        $book4 = Book::where('code', 'TEK-001')->first();

        if ($book1) {
            Loan::create([
                'book_id' => $book1->id,
                'borrower_name' => 'Muhammad Rizky Pratama',
                'student_id' => 'NISN-0081234567',
                'student_class' => 'XI PPLG 1',
                'phone' => '081234567890',
                'loan_date' => now()->subDays(3)->toDateString(),
                'due_date' => now()->addDays(4)->toDateString(),
                'return_date' => null,
                'status' => 'borrowed',
                'fine' => 0,
                'notes' => 'Peminjaman untuk tugas kejuruan rekayasa perangkat lunak.',
            ]);

            Loan::create([
                'book_id' => $book1->id,
                'borrower_name' => 'Siti Aisyah Putri',
                'student_id' => 'NISN-0081234568',
                'student_class' => 'XI PPLG 2',
                'phone' => '081234567891',
                'loan_date' => now()->subDays(12)->toDateString(),
                'due_date' => now()->subDays(5)->toDateString(),
                'return_date' => null,
                'status' => 'overdue',
                'fine' => 5000, // 5 days * Rp 1.000
                'notes' => 'Buku belum dikembalikan, sudah melewati jatuh tempo.',
            ]);
        }

        if ($book2) {
            Loan::create([
                'book_id' => $book2->id,
                'borrower_name' => 'Ahmad Fadhil',
                'student_id' => 'NISN-0081234569',
                'student_class' => 'XII TJKT 1',
                'phone' => '081234567892',
                'loan_date' => now()->subDays(5)->toDateString(),
                'due_date' => now()->addDays(2)->toDateString(),
                'return_date' => null,
                'status' => 'borrowed',
                'fine' => 0,
                'notes' => 'Buku persiapan ujian fisika terapan teknik.',
            ]);

            Loan::create([
                'book_id' => $book2->id,
                'borrower_name' => 'Nabila Zahra',
                'student_id' => 'NISN-0081234570',
                'student_class' => 'XII TJKT 2',
                'phone' => '081234567893',
                'loan_date' => now()->subDays(14)->toDateString(),
                'due_date' => now()->subDays(7)->toDateString(),
                'return_date' => now()->subDays(7)->toDateString(),
                'status' => 'returned',
                'fine' => 0,
                'notes' => 'Buku dikembalikan tepat waktu dalam kondisi baik.',
            ]);
        }

        if ($book3) {
            Loan::create([
                'book_id' => $book3->id,
                'borrower_name' => 'Bintang Ramadhan',
                'student_id' => 'NISN-0081234571',
                'student_class' => 'X DKV 1',
                'phone' => '081234567894',
                'loan_date' => now()->subDays(2)->toDateString(),
                'due_date' => now()->addDays(5)->toDateString(),
                'return_date' => null,
                'status' => 'borrowed',
                'fine' => 0,
                'notes' => 'Membaca untuk literasi mingguan siswa DKV.',
            ]);

            Loan::create([
                'book_id' => $book3->id,
                'borrower_name' => 'Dimas Arya',
                'student_id' => 'NISN-0081234572',
                'student_class' => 'X Animasi 2',
                'phone' => '081234567895',
                'loan_date' => now()->subDays(10)->toDateString(),
                'due_date' => now()->subDays(3)->toDateString(),
                'return_date' => now()->subDays(1)->toDateString(),
                'status' => 'returned',
                'fine' => 2000,
                'notes' => 'Terlambat 2 hari, denda telah dibayar lunas Rp 2.000.',
            ]);
        }

        if ($book4) {
            Loan::create([
                'book_id' => $book4->id,
                'borrower_name' => 'Kevin Sanjaya',
                'student_id' => 'NISN-0081234573',
                'student_class' => 'XI PPLG 1',
                'phone' => '081234567896',
                'loan_date' => now()->subDays(4)->toDateString(),
                'due_date' => now()->addDays(3)->toDateString(),
                'return_date' => null,
                'status' => 'borrowed',
                'fine' => 0,
                'notes' => 'Referensi tugas praktikum web.',
            ]);
        }
    }
}
