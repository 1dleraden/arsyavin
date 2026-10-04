<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $loanDate = fake()->dateTimeBetween('-30 days', 'now');
        $dueDate = (clone $loanDate)->modify('+7 days');

        return [
            'book_id' => Book::factory(),
            'borrower_name' => fake()->name(),
            'student_id' => 'NISN-'.fake()->numerify('##########'),
            'student_class' => fake()->randomElement(['X IPA 1', 'X IPS 2', 'XI MIPA 3', 'XII IPS 1', 'XI RPL 2']),
            'phone' => fake()->phoneNumber(),
            'loan_date' => $loanDate->format('Y-m-d'),
            'due_date' => $dueDate->format('Y-m-d'),
            'return_date' => null,
            'status' => 'borrowed',
            'fine' => 0,
            'notes' => fake()->sentence(),
        ];
    }
}
