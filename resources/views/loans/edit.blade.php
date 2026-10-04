@extends('layouts.app')

@section('title', 'Edit Data Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('loans.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Kembali ke Sirkulasi
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Edit Transaksi Peminjaman</h1>
                    <p class="text-xs text-slate-500">ID: <span class="font-mono font-semibold">#TRX-{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }}</span></p>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $loan->status === 'returned' ? 'bg-emerald-50 text-emerald-700' : ($loan->status === 'overdue' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">
                Status: {{ ucfirst($loan->status) }}
            </span>
        </div>

        <form action="{{ route('loans.update', $loan) }}" method="POST" class="p-6 sm:p-8 space-y-5">
            @csrf
            @method('PUT')

            <!-- Info Buku (Readonly) -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70">
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Buku yang Dipinjam</span>
                <div class="font-bold text-slate-900 text-sm">{{ $loan->book->title }}</div>
                <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $loan->book->code }} &bull; {{ $loan->book->author }}</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Siswa -->
                <div>
                    <label for="borrower_name" class="block text-xs font-semibold text-slate-700 mb-1">
                        Nama Lengkap Siswa <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="borrower_name" 
                           id="borrower_name" 
                           value="{{ old('borrower_name', $loan->borrower_name) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('borrower_name') border-rose-500 @enderror"
                           required>
                    @error('borrower_name')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NISN / NIS -->
                <div>
                    <label for="student_id" class="block text-xs font-semibold text-slate-700 mb-1">
                        NISN / NIS <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="student_id" 
                           id="student_id" 
                           value="{{ old('student_id', $loan->student_id) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none @error('student_id') border-rose-500 @enderror"
                           required>
                    @error('student_id')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Kelas -->
                <div>
                    <label for="student_class" class="block text-xs font-semibold text-slate-700 mb-1">
                        Kelas <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="student_class" 
                           id="student_class" 
                           value="{{ old('student_class', $loan->student_class) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('student_class') border-rose-500 @enderror"
                           required>
                    @error('student_class')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1">
                        No. HP / WhatsApp
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone', $loan->phone) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('phone') border-rose-500 @enderror">
                    @error('phone')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Tanggal Pinjam -->
                <div>
                    <label for="loan_date" class="block text-xs font-semibold text-slate-700 mb-1">
                        Tanggal Pinjam <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" 
                           name="loan_date" 
                           id="loan_date" 
                           value="{{ old('loan_date', $loan->loan_date->toDateString()) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('loan_date') border-rose-500 @enderror"
                           required>
                    @error('loan_date')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Batas Kembali -->
                <div>
                    <label for="due_date" class="block text-xs font-semibold text-slate-700 mb-1">
                        Batas Pengembalian <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" 
                           name="due_date" 
                           id="due_date" 
                           value="{{ old('due_date', $loan->due_date->toDateString()) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('due_date') border-rose-500 @enderror"
                           required>
                    @error('due_date')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Denda -->
            <div>
                <label for="fine" class="block text-xs font-semibold text-slate-700 mb-1">
                    Denda Keterlambatan (Rupiah) <span class="text-rose-500">*</span>
                </label>
                <input type="number" 
                       name="fine" 
                       id="fine" 
                       value="{{ old('fine', $loan->fine) }}" 
                       min="0" 
                       step="500" 
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none @error('fine') border-rose-500 @enderror"
                       required>
                <p class="text-[11px] text-slate-400 mt-1">Dapat disesuaikan jika siswa telah membayar atau ada dispensasi khusus.</p>
                @error('fine')
                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div>
                <label for="notes" class="block text-xs font-semibold text-slate-700 mb-1">
                    Catatan Peminjaman
                </label>
                <textarea name="notes" 
                          id="notes" 
                          rows="2" 
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('notes') border-rose-500 @enderror">{{ old('notes', $loan->notes) }}</textarea>
                @error('notes')
                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('loans.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold shadow-md shadow-amber-500/20 active:scale-95 transition-all">
                    <i class="fa-solid fa-check mr-1.5"></i> Perbarui Data Pinjam
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
