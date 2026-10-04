<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Peminjaman #{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }} — {{ $loan->borrower_name }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
        }
        .barcode {
            font-family: 'Libre Barcode 39 Text', cursive;
            font-size: 38px;
            letter-spacing: 2px;
        }
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-card {
                box-shadow: none !important;
                border: 1px solid #94a3b8 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-8 px-4 flex flex-col items-center">

    <!-- Action Bar (hidden on print) -->
    <div class="no-print max-w-lg w-full mb-6 flex items-center justify-between">
        <a href="{{ route('loans.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white px-3 py-2 rounded-xl border border-slate-200 shadow-2xs">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl shadow-md shadow-blue-500/20 active:scale-95 transition-all">
            <i class="fa-solid fa-print"></i> Cetak Bukti Pinjam
        </button>
    </div>

    <!-- Printable Slip Card -->
    <div class="print-card max-w-lg w-full bg-white rounded-2xl border border-slate-200/90 shadow-xl p-6 sm:p-8 space-y-6">
        
        <!-- School Header Kop Surat -->
        <div class="border-b-2 border-slate-800 pb-4 text-center relative">
            <div class="flex items-center justify-center gap-3 mb-1">
                <div class="w-10 h-10 rounded-xl bg-blue-900 text-white flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <div class="text-left">
                    <h2 class="text-base font-extrabold text-slate-900 uppercase tracking-tight">PERPUSTAKAAN SMKN 1 CIOMAS</h2>
                    <p class="text-[10px] text-slate-500 font-medium">Jl. Raya Laladon, Kec. Ciomas, Kab. Bogor &bull; Telp. (0251) 7520333</p>
                </div>
            </div>
            <div class="text-xs font-bold uppercase tracking-widest text-blue-900 mt-2">
                BUKTI PEMINJAMAN BUKU PERPUSTAKAAN SMKN 1 CIOMAS
            </div>
        </div>

        <!-- Barcode & ID -->
        <div class="flex items-center justify-between bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs">
            <div>
                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Nomor Transaksi</span>
                <span class="font-mono font-bold text-sm text-slate-900">TRX-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Tanggal Cetak</span>
                <span class="font-medium text-slate-700">{{ now()->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <!-- Student Data -->
        <div class="space-y-2 text-xs">
            <h4 class="font-bold text-slate-800 text-[11px] uppercase tracking-wider border-b border-slate-100 pb-1">
                Data Peminjam:
            </h4>
            <div class="grid grid-cols-3 gap-1">
                <span class="text-slate-400">Nama Siswa</span>
                <span class="col-span-2 font-bold text-slate-900">: {{ $loan->borrower_name }}</span>
            </div>
            <div class="grid grid-cols-3 gap-1">
                <span class="text-slate-400">NISN / NIS</span>
                <span class="col-span-2 font-mono font-semibold text-slate-800">: {{ $loan->student_id }}</span>
            </div>
            <div class="grid grid-cols-3 gap-1">
                <span class="text-slate-400">Kelas</span>
                <span class="col-span-2 font-semibold text-slate-800">: {{ $loan->student_class }}</span>
            </div>
            @if($loan->phone)
                <div class="grid grid-cols-3 gap-1">
                    <span class="text-slate-400">No. HP / WA</span>
                    <span class="col-span-2 text-slate-700">: {{ $loan->phone }}</span>
                </div>
            @endif
        </div>

        <!-- Book Data -->
        <div class="space-y-2 text-xs">
            <h4 class="font-bold text-slate-800 text-[11px] uppercase tracking-wider border-b border-slate-100 pb-1">
                Detail Buku yang Dipinjam:
            </h4>
            <div class="p-3 bg-blue-50/60 rounded-xl border border-blue-100 space-y-1.5">
                <div class="font-bold text-slate-900 text-sm leading-snug">{{ $loan->book->title }}</div>
                <div class="text-slate-600 flex items-center gap-2">
                    <span class="font-mono font-bold bg-white px-1.5 py-0.5 rounded border border-blue-200 text-[10px]">{{ $loan->book->code }}</span>
                    <span>Penulis: {{ $loan->book->author }}</span>
                </div>
                <div class="text-[11px] text-slate-500">
                    Kategori: <strong>{{ $loan->book->category }}</strong> &bull; Rak: <strong>{{ $loan->book->shelf_location ?? '-' }}</strong>
                </div>
            </div>
        </div>

        <!-- Schedule Dates -->
        <div class="grid grid-cols-2 gap-3 text-xs">
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-slate-400 text-[10px] uppercase font-semibold block mb-0.5">Tanggal Pinjam</span>
                <span class="font-bold text-slate-900 text-sm">{{ $loan->loan_date->format('d M Y') }}</span>
            </div>
            <div class="p-3 rounded-xl bg-rose-50/70 border border-rose-100">
                <span class="text-rose-600 text-[10px] uppercase font-bold block mb-0.5">Batas Pengembalian</span>
                <span class="font-bold text-rose-900 text-sm">{{ $loan->due_date->format('d M Y') }}</span>
            </div>
        </div>

        <!-- Terms / Notice -->
        <div class="p-3 rounded-xl bg-amber-50/70 border border-amber-200/80 text-[11px] text-amber-900 leading-relaxed">
            <i class="fa-solid fa-triangle-exclamation mr-1 text-amber-600"></i>
            <strong>Perhatian:</strong> Harap mengembalikan buku tepat waktu sebelum tanggal <strong>{{ $loan->due_date->format('d M Y') }}</strong>. Keterlambatan dikenakan denda administrasi <strong>Rp 1.000 / hari</strong>. Kerusakan atau kehilangan buku wajib diganti.
        </div>

        <!-- Signatures -->
        <div class="pt-6 border-t border-slate-200 grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <span class="text-slate-400 text-[11px] block mb-12">Peminjam / Siswa,</span>
                <span class="font-bold text-slate-800 block border-b border-slate-300 pb-1 max-w-[140px] mx-auto">
                    {{ $loan->borrower_name }}
                </span>
                <span class="text-[10px] text-slate-400 block mt-0.5">{{ $loan->student_id }}</span>
            </div>
            <div>
                <span class="text-slate-400 text-[11px] block mb-12">Petugas Perpustakaan,</span>
                <span class="font-bold text-slate-800 block border-b border-slate-300 pb-1 max-w-[140px] mx-auto">
                    Admin Perpustakaan
                </span>
                <span class="text-[10px] text-slate-400 block mt-0.5">NIP. 19850412 201001 1 008</span>
            </div>
        </div>

        <!-- Barcode Simulation -->
        <div class="text-center pt-2 border-t border-slate-100">
            <div class="barcode font-mono text-2xl text-slate-800 tracking-widest">*TRX{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}*</div>
            <span class="text-[9px] text-slate-400 block -mt-1 font-mono">Simpan slip ini sebagai bukti transaksi sah</span>
        </div>

    </div>

</body>
</html>
