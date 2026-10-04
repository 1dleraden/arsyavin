<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display library dashboard statistics and recent activity.
     */
    public function index(): View
    {
        // Auto-check overdue loans
        $overdueLoans = Loan::where('status', 'borrowed')
            ->whereDate('due_date', '<', now()->toDateString())
            ->get();

        foreach ($overdueLoans as $loan) {
            $days = $loan->due_date->startOfDay()->diffInDays(now()->startOfDay());
            $loan->update([
                'status' => 'overdue',
                'fine' => $days * 1000,
            ]);
        }

        $totalBooks = Book::count();
        $totalCopies = Book::sum('stock');
        $availableCopies = Book::sum('available_stock');
        $activeLoansCount = Loan::whereIn('status', ['borrowed', 'overdue'])->count();
        $overdueCount = Loan::where('status', 'overdue')->count();
        $returnedCount = Loan::where('status', 'returned')->count();
        $totalFines = Loan::sum('fine');

        $recentLoans = Loan::with('book')
            ->latest()
            ->take(6)
            ->get();

        $popularBooks = Book::withCount('loans')
            ->orderByDesc('loans_count')
            ->take(4)
            ->get();

        $categories = Book::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get();

        return view('dashboard', compact(
            'totalBooks',
            'totalCopies',
            'availableCopies',
            'activeLoansCount',
            'overdueCount',
            'returnedCount',
            'totalFines',
            'recentLoans',
            'popularBooks',
            'categories'
        ));
    }
}
