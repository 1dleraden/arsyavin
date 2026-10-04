<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of books with search and filter.
     */
    public function index(Request $request): View
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        $categories = Book::select('category')->distinct()->pluck('category');
        $books = $query->latest()->paginate(9)->withQueryString();

        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        $categories = ['Pelajaran', 'Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Umum', 'Agama', 'Bahasa'];

        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:books,code'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'category' => ['required', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:1', 'max:9999'],
            'shelf_location' => ['nullable', 'string', 'max:100'],
            'cover_url' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['available_stock'] = $validated['stock'];

        Book::create($validated);

        return redirect()->route('books.index')->with('success', "Buku '{$validated['title']}' berhasil ditambahkan ke katalog perpustakaan.");
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        $book->load(['loans' => function ($query) {
            $query->latest();
        }]);

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book): View
    {
        $categories = ['Pelajaran', 'Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Umum', 'Agama', 'Bahasa'];

        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:books,code,'.$book->id],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'category' => ['required', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:1', 'max:9999'],
            'shelf_location' => ['nullable', 'string', 'max:100'],
            'cover_url' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
        ]);

        // Adjust available_stock proportionally if stock changes
        $borrowedCount = $book->stock - $book->available_stock;
        if ($validated['stock'] < $borrowedCount) {
            return back()->withInput()->withErrors([
                'stock' => "Stok baru ({$validated['stock']}) tidak boleh kurang dari jumlah buku yang sedang dipinjam ({$borrowedCount}).",
            ]);
        }

        $validated['available_stock'] = $validated['stock'] - $borrowedCount;
        $book->update($validated);

        return redirect()->route('books.show', $book)->with('success', "Data buku '{$book->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        // Check if there are active loans
        $activeLoansCount = $book->activeLoans()->count();
        if ($activeLoansCount > 0) {
            return back()->with('error', "Buku '{$book->title}' tidak dapat dihapus karena sedang dipinjam oleh {$activeLoansCount} siswa.");
        }

        $title = $book->title;
        $book->delete();

        return redirect()->route('books.index')->with('success', "Buku '{$title}' berhasil dihapus dari perpustakaan.");
    }
}
