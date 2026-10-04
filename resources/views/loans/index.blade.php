@extends('layouts.app')

@section('title', 'Sirkulasi Peminjaman Buku')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Sirkulasi Peminjaman Buku</h1>
            <p class="text-sm text-slate-500">Pencatatan data pinjam, pengembalian, status jatuh tempo, dan denda siswa.</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 transition-all">
                <i class="fa-solid fa-file-invoice text-xs text-slate-500"></i>
                Rekap Laporan
            </a>
            <a href="{{ route('loans.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-500/30 transition-all">
                <i class="fa-solid fa-plus text-xs"></i>
                Catat Peminjaman
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs space-y-3">
        
        <!-- Status Tabs -->
        <div class="flex flex-wrap items-center gap-2 pb-3 border-b border-slate-100 text-xs">
            <a href="{{ route('loans.index') }}" 
               class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ !request('status') || request('status') === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua ({{ $stats['total'] }})
            </a>
            <a href="{{ route('loans.index', ['status' => 'borrowed', 'search' => request('search')]) }}" 
               class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ request('status') === 'borrowed' ? 'bg-amber-600 text-white shadow-xs' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                Sedang Dipinjam ({{ $stats['borrowed'] }})
            </a>
            <a href="{{ route('loans.index', ['status' => 'overdue', 'search' => request('search')]) }}" 
               class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ request('status') === 'overdue' ? 'bg-rose-600 text-white shadow-xs' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                Jatuh Tempo ({{ $stats['overdue'] }})
            </a>
            <a href="{{ route('loans.index', ['status' => 'returned', 'search' => request('search')]) }}" 
               class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ request('status') === 'returned' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                Sudah Kembali ({{ $stats['returned'] }})
            </a>
            <div class="ml-auto text-xs font-semibold text-slate-500 hidden md:block">
                Total Denda: <span class="text-rose-600 font-bold">Rp {{ number_format($stats['total_fines'], 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Search Form -->
        <form action="{{ route('loans.index') }}" method="GET" class="flex items-center gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari nama siswa, NISN, kelas, atau judul buku..." 
                       class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('loans.index', ['status' => request('status')]) }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-sm hover:bg-slate-200 transition-colors" title="Reset Cari">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>

    </div>

    <!-- Loans Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        
        @if($loans->isEmpty())
            <div class="p-12 text-center text-slate-400">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak ada data peminjaman</h3>
                <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Belum ada catatan peminjaman yang sesuai dengan filter ini.</p>
                <a href="{{ route('loans.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fa-solid fa-plus"></i> Pinjam Buku Baru
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-3.5">ID / Tgl</th>
                            <th class="px-5 py-3.5">Nama Peminjam</th>
                            <th class="px-5 py-3.5">Buku Dipinjam</th>
                            <th class="px-5 py-3.5">Jadwal Pengembalian</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Denda</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($loans as $loan)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <!-- ID / Tgl -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-slate-700 block">#TRX-{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $loan->loan_date->format('d M Y') }}</span>
                                </td>

                                <!-- Siswa -->
                                <td class="px-5 py-4">
                                    <div class="font-bold text-slate-900">{{ $loan->borrower_name }}</div>
                                    <div class="text-xs text-slate-500">
                                        {{ $loan->student_class }} &bull; <span class="font-mono">{{ $loan->student_id }}</span>
                                    </div>
                                    @if($loan->phone)
                                        <div class="text-[11px] text-slate-400 mt-0.5">
                                            <i class="fa-brands fa-whatsapp text-emerald-600 mr-1"></i>{{ $loan->phone }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Buku -->
                                <td class="px-5 py-4 max-w-xs">
                                    <a href="{{ route('books.show', $loan->book) }}" class="font-semibold text-slate-800 hover:text-blue-600 line-clamp-1">
                                        {{ $loan->book->title }}
                                    </a>
                                    <div class="text-xs text-slate-500 font-mono flex items-center gap-1.5 mt-0.5">
                                        <span class="px-1.5 py-0.2 bg-slate-100 rounded text-[10px]">{{ $loan->book->code }}</span>
                                        <span>{{ $loan->book->shelf_location }}</span>
                                    </div>
                                </td>

                                <!-- Jadwal -->
                                <td class="px-5 py-4 text-xs text-slate-600 whitespace-nowrap">
                                    <div>Batas: <strong>{{ $loan->due_date->format('d M Y') }}</strong></div>
                                    @if($loan->return_date)
                                        <div class="text-emerald-700 font-medium mt-0.5">
                                            Kembali: {{ $loan->return_date->format('d M Y') }}
                                        </div>
                                    @else
                                        @if($loan->status === 'overdue')
                                            <div class="text-rose-600 font-bold mt-0.5">
                                                Telat {{ $loan->overdueDays() }} hari
                                            </div>
                                        @else
                                            <div class="text-amber-600 mt-0.5">
                                                Sisa {{ now()->startOfDay()->diffInDays($loan->due_date->startOfDay()) }} hari
                                            </div>
                                        @endif
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="px-5 py-4 whitespace-nowrap">
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
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                    @endif
                                </td>

                                <!-- Denda -->
                                <td class="px-5 py-4 whitespace-nowrap text-xs">
                                    @if($loan->fine > 0)
                                        <span class="font-bold text-rose-600">Rp {{ number_format($loan->fine, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-slate-400">Rp 0</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        
                                        <!-- Tombol Pengembalian -->
                                        @if($loan->status !== 'returned')
                                            <form action="{{ route('loans.return', $loan) }}" method="POST" class="inline" onsubmit="return confirm('Proses pengembalian buku untuk siswa {{ $loan->borrower_name }}?')">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-2xs transition-colors" title="Tandai Dikembalikan">
                                                    <i class="fa-solid fa-arrow-rotate-left mr-1"></i> Kembali
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Cetak Slip -->
                                        <a href="{{ route('loans.slip', $loan) }}" target="_blank" class="p-1.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors" title="Cetak Kartu / Slip Pinjam">
                                            <i class="fa-solid fa-print"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('loans.edit', $loan) }}" class="p-1.5 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Transaksi">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus catatan transaksi peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-100">
                {{ $loans->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
