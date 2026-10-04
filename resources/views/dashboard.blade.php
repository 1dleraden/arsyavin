@extends('layouts.app')

@section('title', 'Dashboard Perpustakaan')

@section('content')
<div class="space-y-8">
    
    <!-- Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white p-6 sm:p-8 shadow-xl">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-blue-200 text-xs font-semibold backdrop-blur-xs mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Tahun Ajaran 2025/2026 &bull; Semester Ganjil
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang di Perpustakaan SMKN 1 Ciomas</h1>
                <p class="mt-2 text-slate-300 text-sm max-w-xl leading-relaxed">
                    Sistem otomasi perpustakaan sekolah untuk kemudahan katalogisasi buku, pencatatan sirkulasi peminjaman siswa, dan transparansi denda keterlambatan.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('loans.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-blue-500 hover:bg-blue-400 text-white shadow-lg shadow-blue-500/25 transition-all">
                    <i class="fa-solid fa-circle-plus"></i>
                    Pinjamkan Buku
                </a>
                <a href="{{ route('books.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/20 transition-all">
                    <i class="fa-solid fa-book-medical"></i>
                    Buku Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        
        <!-- Total Judul -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Judul Buku</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ number_format($totalBooks) }}</div>
            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                <span class="text-blue-600 font-semibold">{{ $categories->count() }}</span> kategori aktif
            </p>
        </div>

        <!-- Total Eksemplar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Eksemplar</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ number_format($totalCopies) }}</div>
            <p class="text-xs text-slate-500 mt-1">
                <span class="text-emerald-600 font-semibold">{{ $availableCopies }}</span> siap dipinjam
            </p>
        </div>

        <!-- Sedang Dipinjam -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sedang Dipinjam</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-handshake-angle"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-amber-600">{{ number_format($activeLoansCount) }}</div>
            <p class="text-xs text-slate-500 mt-1">
                Oleh siswa sekolah
            </p>
        </div>

        <!-- Terlambat / Overdue -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Jatuh Tempo</span>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
            </div>
            <div class="text-2xl font-black {{ $overdueCount > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ number_format($overdueCount) }}</div>
            <p class="text-xs text-slate-500 mt-1">
                @if($overdueCount > 0)
                    <span class="text-rose-600 font-medium">Perlu ditindaklanjuti</span>
                @else
                    <span class="text-emerald-600 font-medium">Semua tepat waktu</span>
                @endif
            </p>
        </div>

        <!-- Total Denda -->
        <div class="col-span-2 lg:col-span-1 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Denda</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-rupiah-sign"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">Rp {{ number_format($totalFines, 0, ',', '.') }}</div>
            <p class="text-xs text-slate-500 mt-1">
                Tarif Rp 1.000 / hari
            </p>
        </div>

    </div>

    <!-- Main Two-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Recent Loans (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Sirkulasi Peminjaman Terbaru</h2>
                    <p class="text-xs text-slate-500">Aktivitas peminjaman dan pengembalian siswa</p>
                </div>
                <a href="{{ route('loans.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            @if($recentLoans->isEmpty())
                <div class="p-8 text-center text-slate-400">
                    <i class="fa-solid fa-book-open text-4xl mb-3 text-slate-300"></i>
                    <p class="text-sm">Belum ada riwayat transaksi peminjaman.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-100">
                            <tr>
                                <th class="px-5 py-3">Siswa</th>
                                <th class="px-5 py-3">Buku</th>
                                <th class="px-5 py-3">Batas Kembali</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentLoans as $loan)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <div class="font-semibold text-slate-800">{{ $loan->borrower_name }}</div>
                                        <div class="text-xs text-slate-500">{{ $loan->student_class }} &bull; {{ $loan->student_id }}</div>
                                    </td>
                                    <td class="px-5 py-3.5 max-w-xs">
                                        <div class="font-medium text-slate-800 truncate" title="{{ $loan->book->title }}">
                                            {{ $loan->book->title }}
                                        </div>
                                        <div class="text-xs text-slate-500 font-mono">{{ $loan->book->code }}</div>
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-slate-600">
                                        {{ $loan->due_date->format('d M Y') }}
                                        @if($loan->status === 'overdue')
                                            <span class="block text-rose-600 font-semibold">
                                                Telat {{ $loan->overdueDays() }} hari
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($loan->status === 'borrowed')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Dipinjam
                                            </span>
                                        @elseif($loan->status === 'overdue')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Kembali
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        @if($loan->status !== 'returned')
                                            <form action="{{ route('loans.return', $loan) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg border border-emerald-200 transition-colors">
                                                    <i class="fa-solid fa-arrow-rotate-left mr-1"></i> Kembali
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('loans.slip', $loan) }}" target="_blank" class="px-2.5 py-1 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                                <i class="fa-solid fa-print mr-1"></i> Slip
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Right: Popular Books & Category Distribution (1 Col) -->
        <div class="space-y-6">
            
            <!-- Most Popular Books -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-fire text-amber-500"></i>
                        Buku Paling Populer
                    </h2>
                    <span class="text-[11px] text-slate-400">Total Pinjam</span>
                </div>
                <div class="space-y-3">
                    @forelse($popularBooks as $index => $book)
                        <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <span class="w-6 h-6 rounded-lg {{ $index === 0 ? 'bg-amber-100 text-amber-700 font-bold' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center text-xs font-semibold shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('books.show', $book) }}" class="font-semibold text-slate-800 text-xs hover:text-blue-600 truncate block">
                                    {{ $book->title }}
                                </a>
                                <span class="text-[11px] text-slate-400">{{ $book->category }} &bull; {{ $book->author }}</span>
                            </div>
                            <span class="text-xs font-bold text-blue-600 px-2 py-0.5 rounded-md bg-blue-50 shrink-0">
                                {{ $book->loans_count }}x
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada statistik buku.</p>
                    @endforelse
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5">
                <h2 class="font-bold text-slate-900 text-sm mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-shapes text-indigo-500"></i>
                    Kategori Koleksi
                </h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $cat)
                        <a href="{{ route('books.index', ['category' => $cat->category]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 border border-slate-200 hover:border-blue-200 transition-colors">
                            <span>{{ $cat->category }}</span>
                            <span class="w-4 h-4 rounded-full bg-slate-200 group-hover:bg-blue-200 text-slate-700 flex items-center justify-center text-[10px] font-bold">
                                {{ $cat->count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- School Info Card -->
            <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 text-blue-950 text-xs">
                <div class="font-bold text-sm text-blue-900 mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-question text-blue-600"></i>
                    Aturan Peminjaman
                </div>
                <ul class="list-disc list-inside space-y-1 text-slate-600 mt-2">
                    <li>Batas peminjaman maksimal <strong>7 hari</strong>.</li>
                    <li>Denda keterlambatan <strong>Rp 1.000 / hari</strong>.</li>
                    <li>Maksimal 2 buku sekaligus per siswa.</li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection
