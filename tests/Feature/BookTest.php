<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_dashboard(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('SMKN 1 Ciomas');
    }

    public function test_can_render_books_index(): void
    {
        Book::factory()->create(['title' => 'Buku Uji Coba Kimia']);

        $response = $this->get(route('books.index'));
        $response->assertStatus(200);
        $response->assertSee('Buku Uji Coba Kimia');
    }

    public function test_can_render_create_book_page(): void
    {
        $response = $this->get(route('books.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Buku Baru');
    }

    public function test_can_create_a_new_book(): void
    {
        $bookData = [
            'code' => 'PLJ-999',
            'title' => 'Geografi Kelas XI',
            'author' => 'Suharyono',
            'publisher' => 'Balai Pustaka',
            'year' => 2023,
            'category' => 'Pelajaran',
            'stock' => 10,
            'shelf_location' => 'Rak A-09',
            'cover_url' => 'https://example.com/cover.jpg',
            'description' => 'Buku teks utama geografi.',
        ];

        $response = $this->post(route('books.store'), $bookData);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', [
            'code' => 'PLJ-999',
            'title' => 'Geografi Kelas XI',
            'available_stock' => 10,
        ]);
    }

    public function test_can_render_book_detail(): void
    {
        $book = Book::factory()->create(['title' => 'Buku Geografi Modern']);

        $response = $this->get(route('books.show', $book));
        $response->assertStatus(200);
        $response->assertSee('Buku Geografi Modern');
    }

    public function test_can_update_a_book(): void
    {
        $book = Book::factory()->create([
            'stock' => 5,
            'available_stock' => 5,
        ]);

        $updateData = [
            'code' => $book->code,
            'title' => 'Judul Buku Telah Diperbarui',
            'author' => $book->author,
            'publisher' => $book->publisher,
            'year' => 2024,
            'category' => $book->category,
            'stock' => 8,
            'shelf_location' => 'Rak Z-01',
            'cover_url' => null,
            'description' => 'Updated synopsis.',
        ];

        $response = $this->put(route('books.update', $book), $updateData);

        $response->assertRedirect(route('books.show', $book));
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Judul Buku Telah Diperbarui',
            'stock' => 8,
            'available_stock' => 8,
        ]);
    }

    public function test_can_delete_a_book_without_active_loans(): void
    {
        $book = Book::factory()->create();

        $response = $this->delete(route('books.destroy', $book));

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_cannot_delete_a_book_with_active_loans(): void
    {
        $book = Book::factory()->create();
        Loan::factory()->create([
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);

        $response = $this->delete(route('books.destroy', $book));

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}
