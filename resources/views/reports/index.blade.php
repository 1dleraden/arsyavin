@extends('layouts.app')

@section('title', 'Laporan Rekapitulasi Perpustakaan')

@section('content')
<div class="space-y-6">

    <!-- Action Bar (hidden on print) -->
    <div class="no-print flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Laporan Rekapitulasi Perpustakaan</h1>
            <p class="text-sm text-slate-500">Laporan komprehensif data koleksi dan sirkulasi peminjaman buku sekolah.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-500/20 active:scale-95 transition-all">
                <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Printable Paper Sheet -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xl p-6 sm:p-10 space-y-8">
        
        <!-- Official Kop Surat Header -->
        <div class="border-b-4 border-double border-slate-900 pb-4 text-center">
            <div class="flex items-center justify-center gap-4 mb-2">
                <div class="w-14 h-14 rounded-2xl bg-blue-900 text-white flex items-center justify-center text-2xl font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="text-center">
                    <h3 class="text-xs uppercase tracking-widest font-semibold text-slate-500">PEMERINTAH DAERAH PROVINSI JAWA BARAT</h3>
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 uppercase tracking-tight">SMK NEGERI 1 CIOMAS</h2>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-blue-900">UNIT PELAKSANA TEKNIS (UPT) PERPUSTAKAAN</h4>
                    <p class="text-[11px] text-slate-500">Jl. Raya Laladon, Desa Laladon, Kec. Ciomas, Kab. Bogor &bull; Telp: (0251) 7520333 &bull; Email: perpustakaan@smkn1ciomas.sch.id</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide">
                LAPORAN SIRKULASI & INVENTARIS PERPUSTAKAAN
            </h2>
            <p class="text-xs text-slate-500">Periode: {{ now()->translatedFormat('F Y') }} &bull; Tanggal Cetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>

        <!-- Ringkasan Statistik -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60">
                <span class="text-slate-500 block mb-1">Total Judul Koleksi</span>
                <span class="text-xl font-bold text-slate-900">{{ $stats['total_titles'] }} Judul</span>
            </div>
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60">
                <span class="text-slate-500 block mb-1">Total Eksemplar</span>
                <span class="text-xl font-bold text-slate-900">{{ $stats['total_copies'] }} Buku</span>
            </div>
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60">
                <span class="text-slate-500 block mb-1">Sedang Dipinjam</span>
                <span class="text-xl font-bold text-amber-600">{{ $stats['active_loans'] }} Transaksi</span>
            </div>
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60">
                <span class="text-slate-500 block mb-1">Total Denda Terkumpul</span>
                <span class="text-xl font-bold text-emerald-700">Rp {{ number_format($stats['total_fines'], 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Tabel 1: Rekap Sirkulasi Peminjaman -->
        <div class="space-y-3">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-list-check text-blue-600"></i>
                1. Data Transaksi Sirkulasi Peminjaman
            </h3>

            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200 uppercase">
                        <tr>
                            <th class="px-3 py-2.5">No</th>
                            <th class="px-3 py-2.5">ID Transaksi</th>
                            <th class="px-3 py-2.5">Nama Siswa</th>
                            <th class="px-3 py-2.5">Kelas & NISN</th>
                            <th class="px-3 py-2.5">Judul Buku</th>
                            <th class="px-3 py-2.5">Tgl Pinjam</th>
                            <th class="px-3 py-2.5">Jatuh Tempo</th>
                            <th class="px-3 py-2.5">Status</th>
                            <th class="px-3 py-2.5 text-right">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($loans as $index => $loan)
                            <tr class="hover:bg-slate-50">
                                <td class="px-3 py-2 text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-3 py-2 font-mono font-semibold">TRX-{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-3 py-2 font-bold text-slate-800">{{ $loan->borrower_name }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $loan->student_class }} &bull; {{ $loan->student_id }}</td>
                                <td class="px-3 py-2 text-slate-800 max-w-xs truncate">{{ $loan->book->title }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $loan->loan_date->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $loan->due_date->format('d/m/Y') }}</td>
                                <td class="px-3 py-2">
                                    @if($loan->status === 'borrowed')
                                        <span class="text-amber-700 font-semibold">Dipinjam</span>
                                    @elseif($loan->status === 'overdue')
                                        <span class="text-rose-700 font-bold">Terlambat</span>
                                    @else
                                        <span class="text-emerald-700 font-semibold">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-right font-mono {{ $loan->fine > 0 ? 'text-rose-600 font-bold' : 'text-slate-400' }}">
                                    {{ $loan->fine > 0 ? 'Rp ' . number_format($loan->fine, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel 2: Inventaris Buku -->
        <div class="space-y-3 pt-4">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-boxes-stacked text-indigo-600"></i>
                2. Data Inventaris Koleksi Buku
            </h3>

            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200 uppercase">
                        <tr>
                            <th class="px-3 py-2.5">No</th>
                            <th class="px-3 py-2.5">Kode</th>
                            <th class="px-3 py-2.5">Judul Buku</th>
                            <th class="px-3 py-2.5">Penulis</th>
                            <th class="px-3 py-2.5">Kategori</th>
                            <th class="px-3 py-2.5">Lokasi Rak</th>
                            <th class="px-3 py-2.5 text-center">Total Stok</th>
                            <th class="px-3 py-2.5 text-center">Tersedia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($books as $idx => $b)
                            <tr class="hover:bg-slate-50">
                                <td class="px-3 py-2 text-slate-400">{{ $idx + 1 }}</td>
                                <td class="px-3 py-2 font-mono font-semibold">{{ $b->code }}</td>
                                <td class="px-3 py-2 font-bold text-slate-800">{{ $b->title }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $b->author }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $b->category }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $b->shelf_location ?? '-' }}</td>
                                <td class="px-3 py-2 text-center font-bold text-slate-800">{{ $b->stock }}</td>
                                <td class="px-3 py-2 text-center font-bold {{ $b->available_stock > 0 ? 'text-emerald-700' : 'text-rose-600' }}">
                                    {{ $b->available_stock }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tanda Tangan Pejabat Pengesah -->
        <div class="pt-8 border-t border-slate-200 grid grid-cols-2 gap-12 text-center text-xs">
            <div>
                <span class="text-slate-500 block mb-1">Mengetahui,</span>
                <span class="font-bold text-slate-800 block mb-16">Kepala SMK Negeri 1 Ciomas</span>
                <span class="font-bold text-slate-900 underline block text-sm">Drs. H. Mahdi, M.Pd.</span>
                <span class="text-slate-500 block mt-0.5">NIP. 19680817 199303 1 004</span>
            </div>
            <div>
                <span class="text-slate-500 block mb-1">Ciomas, Bogor, {{ now()->translatedFormat('d F Y') }}</span>
                <span class="font-bold text-slate-800 block mb-16">Kepala Perpustakaan Sekolah</span>
                <span class="font-bold text-slate-900 underline block text-sm">Hj. Nurul Hidayati, S.I.Pust.</span>
                <span class="text-slate-500 block mt-0.5">NIP. 19820510 200604 2 011</span>
            </div>
        </div>

    </div>

</div>
@endsection
