<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_loans_index(): void
    {
        $book = Book::factory()->create();
        Loan::factory()->create([
            'book_id' => $book->id,
            'borrower_name' => 'Budi Santoso',
        ]);

        $response = $this->get(route('loans.index'));
        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
    }

    public function test_can_render_create_loan_page(): void
    {
        $response = $this->get(route('loans.create'));
        $response->assertStatus(200);
        $response->assertSee('Form Peminjaman Buku');
    }

    public function test_can_create_a_loan_and_decrements_book_stock(): void
    {
        $book = Book::factory()->create([
            'stock' => 5,
            'available_stock' => 5,
        ]);

        $loanData = [
            'book_id' => $book->id,
            'borrower_name' => 'Ahmad Dani',
            'student_id' => '0089912345',
            'student_class' => 'XI RPL 1',
            'phone' => '081234567890',
            'loan_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'notes' => 'Pinjam untuk referensi belajar.',
        ];

        $response = $this->post(route('loans.store'), $loanData);

        $response->assertRedirect(route('loans.index'));
        $this->assertDatabaseHas('loans', [
            'book_id' => $book->id,
            'borrower_name' => 'Ahmad Dani',
            'status' => 'borrowed',
        ]);

        $book->refresh();
        $this->assertEquals(4, $book->available_stock);
    }

    public function test_can_return_a_book_and_restores_stock(): void
    {
        $book = Book::factory()->create([
            'stock' => 5,
            'available_stock' => 4,
        ]);

        $loan = Loan::factory()->create([
            'book_id' => $book->id,
            'loan_date' => now()->subDays(5)->toDateString(),
            'due_date' => now()->addDays(2)->toDateString(),
            'status' => 'borrowed',
        ]);

        $response = $this->post(route('loans.return', $loan), [
            'return_date' => now()->toDateString(),
        ]);

        $response->assertRedirect(route('loans.index'));
        $loan->refresh();
        $this->assertEquals('returned', $loan->status);
        $this->assertEquals(0, $loan->fine);

        $book->refresh();
        $this->assertEquals(5, $book->available_stock);
    }

    public function test_calculates_fine_when_returned_past_due_date(): void
    {
        $book = Book::factory()->create([
            'stock' => 5,
            'available_stock' => 4,
        ]);

        $loan = Loan::factory()->create([
            'book_id' => $book->id,
            'loan_date' => now()->subDays(10)->toDateString(),
            'due_date' => now()->subDays(3)->toDateString(), // 3 days overdue
            'status' => 'borrowed',
        ]);

        $response = $this->post(route('loans.return', $loan), [
            'return_date' => now()->toDateString(),
        ]);

        $response->assertRedirect(route('loans.index'));
        $loan->refresh();
        $this->assertEquals('returned', $loan->status);
        $this->assertEquals(3000, $loan->fine); // 3 days * 1000 = 3000
    }

    public function test_can_render_loan_slip(): void
    {
        $book = Book::factory()->create();
        $loan = Loan::factory()->create([
            'book_id' => $book->id,
            'borrower_name' => 'Citra Lestari',
        ]);

        $response = $this->get(route('loans.slip', $loan));
        $response->assertStatus(200);
        $response->assertSee('Citra Lestari');
        $response->assertSee('BUKTI PEMINJAMAN BUKU PERPUSTAKAAN');
    }

    public function test_can_render_reports_page(): void
    {
        $response = $this->get(route('reports.index'));
        $response->assertStatus(200);
        $response->assertSee('LAPORAN SIRKULASI', false);
    }

    public function test_can_delete_loan_and_restores_stock(): void
    {
        $book = Book::factory()->create([
            'stock' => 5,
            'available_stock' => 4,
        ]);

        $loan = Loan::factory()->create([
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);

        $response = $this->delete(route('loans.destroy', $loan));

        $response->assertRedirect(route('loans.index'));
        $this->assertDatabaseMissing('loans', ['id' => $loan->id]);

        $book->refresh();
        $this->assertEquals(5, $book->available_stock);
    }
}
