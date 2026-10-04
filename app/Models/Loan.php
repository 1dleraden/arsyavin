<?php

namespace App\Models;

use Database\Factories\LoanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /** @use HasFactory<LoanFactory> */
    use HasFactory;

    protected $fillable = [
        'book_id',
        'borrower_name',
        'student_id',
        'student_class',
        'phone',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'fine',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'loan_date' => 'date',
            'due_date' => 'date',
            'return_date' => 'date',
            'fine' => 'integer',
        ];
    }

    /**
     * Get the book being loaned.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if the loan is overdue.
     */
    public function isOverdue(): bool
    {
        if ($this->status === 'returned') {
            return false;
        }

        return now()->startOfDay()->gt($this->due_date->startOfDay());
    }

    /**
     * Calculate days overdue.
     */
    public function overdueDays(): int
    {
        if ($this->status === 'returned') {
            if ($this->return_date && $this->return_date->gt($this->due_date)) {
                return $this->due_date->diffInDays($this->return_date);
            }

            return 0;
        }

        if (now()->startOfDay()->gt($this->due_date->startOfDay())) {
            return $this->due_date->startOfDay()->diffInDays(now()->startOfDay());
        }

        return 0;
    }
}
