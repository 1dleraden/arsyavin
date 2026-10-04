<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoanController extends Controller
{
    /**
     * Display a listing of loans with search and filters.
     */
    public function index(Request $request): View
    {
        // Auto-update overdue records on list load
        Loan::where('status', 'borrowed')
            ->whereDate('due_date', '<', now()->toDateString())
            ->each(function ($loan) {
                $days = $loan->due_date->startOfDay()->diffInDays(now()->startOfDay());
                $loan->update([
                    'status' => 'overdue',
                    'fine' => $days * 1000,
                ]);
            });

        $query = Loan::with('book');

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('borrower_name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('student_class', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($bq) use ($search) {
                        $bq->where('title', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        $loans = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => Loan::count(),
            'borrowed' => Loan::where('status', 'borrowed')->count(),
            'overdue' => Loan::where('status', 'overdue')->count(),
            'returned' => Loan::where('status', 'returned')->count(),
            'total_fines' => Loan::sum('fine'),
        ];

        return view('loans.index', compact('loans', 'stats'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create(Request $request): View
    {
        $selectedBookId = $request->input('book_id');
        $books = Book::where('available_stock', '>', 0)->orderBy('title')->get();

        return view('loans.create', compact('books', 'selectedBookId'));
    }

    /**
     * Store a newly created loan in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'borrower_name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:50'],
            'student_class' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'loan_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loan_date'],
            'notes' => ['nullable', 'string'],
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->available_stock < 1) {
            return back()->withInput()->withErrors([
                'book_id' => "Maaf, stok buku '{$book->title}' sedang kosong / habis dipinjam.",
            ]);
        }

        $validated['status'] = 'borrowed';
        $validated['fine'] = 0;

        $loan = Loan::create($validated);

        // Decrement available stock
        $book->decrement('available_stock');

        return redirect()->route('loans.index')->with('success', "Peminjaman buku '{$book->title}' untuk siswa '{$loan->borrower_name}' berhasil dicatat.");
    }

    /**
     * Display the specified loan.
     */
    public function show(Loan $loan): View
    {
        $loan->load('book');

        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function edit(Loan $loan): View
    {
        $loan->load('book');

        return view('loans.edit', compact('loan'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function update(Request $request, Loan $loan): RedirectResponse
    {
        $validated = $request->validate([
            'borrower_name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:50'],
            'student_class' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'loan_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loan_date'],
            'fine' => ['required', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $loan->update($validated);

        return redirect()->route('loans.show', $loan)->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    /**
     * Process book return and fine calculation.
     */
    public function returnBook(Request $request, Loan $loan): RedirectResponse
    {
        if ($loan->status === 'returned') {
            return back()->with('info', 'Buku ini sudah tercatat dikembalikan.');
        }

        $returnDate = $request->input('return_date', now()->toDateString());
        $fine = 0;

        $dueDate = $loan->due_date->startOfDay();
        $retDate = Carbon::parse($returnDate)->startOfDay();

        if ($retDate->gt($dueDate)) {
            $daysOverdue = $dueDate->diffInDays($retDate);
            $fine = $daysOverdue * 1000; // Rp 1.000 / hari
        }

        $loan->update([
            'return_date' => $returnDate,
            'status' => 'returned',
            'fine' => $fine,
        ]);

        // Restore book available stock
        $loan->book->increment('available_stock');

        $message = "Buku '{$loan->book->title}' berhasil dikembalikan.";
        if ($fine > 0) {
            $message .= ' Dikenakan denda keterlambatan sebesar Rp '.number_format($fine, 0, ',', '.').'.';
        }

        return redirect()->route('loans.index')->with('success', $message);
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroy(Loan $loan): RedirectResponse
    {
        // If loan was still active, return stock
        if (in_array($loan->status, ['borrowed', 'overdue'])) {
            $loan->book->increment('available_stock');
        }

        $borrower = $loan->borrower_name;
        $loan->delete();

        return redirect()->route('loans.index')->with('success', "Data transaksi peminjaman atas nama {$borrower} berhasil dihapus.");
    }

    /**
     * Show printable loan slip for student.
     */
    public function printSlip(Loan $loan): View
    {
        $loan->load('book');

        return view('loans.slip', compact('loan'));
    }

    /**
     * Show printable summary report.
     */
    public function report(Request $request): View
    {
        $loans = Loan::with('book')->latest()->get();
        $books = Book::all();

        $stats = [
            'total_titles' => $books->count(),
            'total_copies' => $books->sum('stock'),
            'total_loans' => $loans->count(),
            'active_loans' => $loans->whereIn('status', ['borrowed', 'overdue'])->count(),
            'returned_loans' => $loans->where('status', 'returned')->count(),
            'total_fines' => $loans->sum('fine'),
        ];

        return view('reports.index', compact('loans', 'books', 'stats'));
    }
}
