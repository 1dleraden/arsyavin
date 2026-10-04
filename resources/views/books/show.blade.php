@extends('layouts.app')

@section('title', $book->title . ' — Detail Buku')

@section('content')
<div class="space-y-6">

    <!-- Top Action / Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Kembali ke Katalog
        </a>
        <div class="flex items-center gap-2">
            @if($book->available_stock > 0)
                <a href="{{ route('loans.create', ['book_id' => $book->id]) }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                    <i class="fa-solid fa-handshake"></i> Pinjamkan Buku
                </a>
            @endif
            <a href="{{ route('books.edit', $book) }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-all">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini dari sistem perpustakaan?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-all">
                    <i class="fa-solid fa-trash-can"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 sm:p-8 flex flex-col md:flex-row gap-8">
            
            <!-- Book Cover -->
            <div class="w-full md:w-56 shrink-0 flex flex-col items-center">
                <div class="w-48 h-64 rounded-2xl overflow-hidden shadow-lg border border-slate-200 bg-slate-100 relative group">
                    @if($book->cover_url)
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=300&auto=format&fit=crop&q=80';">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-slate-200 to-slate-100 text-slate-400 p-4 text-center">
                            <i class="fa-solid fa-book-open text-4xl mb-2 text-slate-400"></i>
                            <span class="text-xs font-mono font-semibold">{{ $book->code }}</span>
                        </div>
                    @endif
                </div>

                <div class="w-full mt-4 p-3 rounded-xl bg-slate-50 border border-slate-100 text-center">
                    <span class="text-[11px] uppercase tracking-wider text-slate-400 font-semibold block mb-1">Status Ketersediaan</span>
                    @if($book->available_stock > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Tersedia ({{ $book->available_stock }} dari {{ $book->stock }})
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            Sedang Kosong (0/{{ $book->stock }})
                        </span>
                    @endif
                </div>
            </div>

            <!-- Book Specs -->
            <div class="flex-1 space-y-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold font-mono tracking-wider bg-slate-900 text-white">
                            {{ $book->code }}
                        </span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-800">
                            {{ $book->category }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $book->title }}
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Karya <strong class="text-slate-800">{{ $book->author }}</strong>
                    </p>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 rounded-xl bg-slate-50/80 border border-slate-100 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Penerbit</span>
                        <span class="font-semibold text-slate-800">{{ $book->publisher }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Tahun Terbit</span>
                        <span class="font-semibold text-slate-800">{{ $book->year }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Lokasi Rak</span>
                        <span class="font-semibold text-slate-800">
                            <i class="fa-solid fa-location-dot text-amber-500 mr-1"></i>{{ $book->shelf_location ?? 'Belum Diatur' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Jumlah Dipinjam</span>
                        <span class="font-semibold text-slate-800">{{ $book->stock - $book->available_stock }} eksemplar</span>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Sinopsis & Ringkasan</h3>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $book->description ?: 'Tidak ada sinopsis atau keterangan tambahan untuk buku ini.' }}
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Loan History for this book -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-slate-900 text-base">Riwayat Peminjaman Buku Ini</h2>
                <p class="text-xs text-slate-500">Daftar siswa yang pernah atau sedang meminjam buku ini</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600">
                Total {{ $book->loans->count() }} Peminjaman
            </span>
        </div>

        @if($book->loans->isEmpty())
            <div class="p-8 text-center text-slate-400">
                <i class="fa-solid fa-clock-rotate-left text-3xl mb-2 text-slate-300"></i>
                <p class="text-xs">Buku ini belum pernah dipinjam.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-3">Nama Siswa</th>
                            <th class="px-5 py-3">Kelas & NISN</th>
                            <th class="px-5 py-3">Tgl Pinjam</th>
                            <th class="px-5 py-3">Batas Kembali</th>
                            <th class="px-5 py-3">Tgl Kembali</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($book->loans as $loan)
                            <tr class="hover:bg-slate-50/70">
                                <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $loan->borrower_name }}</td>
                                <td class="px-5 py-3.5 text-xs text-slate-500">{{ $loan->student_class }} &bull; {{ $loan->student_id }}</td>
                                <td class="px-5 py-3.5 text-xs text-slate-600">{{ $loan->loan_date->format('d M Y') }}</td>
                                <td class="px-5 py-3.5 text-xs text-slate-600">{{ $loan->due_date->format('d M Y') }}</td>
                                <td class="px-5 py-3.5 text-xs text-slate-600">
                                    {{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($loan->status === 'borrowed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-700">Dipinjam</span>
                                    @elseif($loan->status === 'overdue')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-50 text-rose-700">Terlambat</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700">Kembali</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-xs font-semibold {{ $loan->fine > 0 ? 'text-rose-600' : 'text-slate-400' }}">
                                    {{ $loan->fine > 0 ? 'Rp ' . number_format($loan->fine, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
