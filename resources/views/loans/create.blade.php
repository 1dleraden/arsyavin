@extends('layouts.app')

@section('title', 'Form Peminjaman Buku')

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
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Form Peminjaman Buku</h1>
                    <p class="text-xs text-slate-500">Catat transaksi peminjaman buku oleh siswa atau anggota perpustakaan.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('loans.store') }}" method="POST" class="p-6 sm:p-8 space-y-5">
            @csrf

            <!-- Pilih Buku -->
            <div>
                <label for="book_id" class="block text-xs font-semibold text-slate-700 mb-1">
                    Pilih Buku yang Dipinjam <span class="text-rose-500">*</span>
                </label>
                <select name="book_id" id="book_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white @error('book_id') border-rose-500 @enderror" required>
                    <option value="">-- Pilih Judul Buku (Stok Tersedia) --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ (old('book_id') == $book->id || $selectedBookId == $book->id) ? 'selected' : '' }}>
                            [{{ $book->code }}] {{ $book->title }} &mdash; (Sisa: {{ $book->available_stock }} eksemplar, Lokasi: {{ $book->shelf_location }})
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <!-- Nama Siswa -->
                <div>
                    <label for="borrower_name" class="block text-xs font-semibold text-slate-700 mb-1">
                        Nama Lengkap Siswa <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="borrower_name" 
                           id="borrower_name" 
                           value="{{ old('borrower_name') }}" 
                           placeholder="Contoh: Muhammad Farhan" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('borrower_name') border-rose-500 @enderror"
                           required>
                    @error('borrower_name')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NISN / NIS -->
                <div>
                    <label for="student_id" class="block text-xs font-semibold text-slate-700 mb-1">
                        Nomor Induk Siswa (NISN / NIS) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="student_id" 
                           id="student_id" 
                           value="{{ old('student_id') }}" 
                           placeholder="Contoh: 0081234567" 
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
                           value="{{ old('student_class') }}" 
                           placeholder="Contoh: XI MIPA 2, X-A, XII IPS 1" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('student_class') border-rose-500 @enderror"
                           required>
                    @error('student_class')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1">
                        No. HP / WhatsApp Siswa (Opsional)
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone') }}" 
                           placeholder="Contoh: 081234567890" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('phone') border-rose-500 @enderror">
                    @error('phone')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <!-- Tanggal Pinjam -->
                <div>
                    <label for="loan_date" class="block text-xs font-semibold text-slate-700 mb-1">
                        Tanggal Pinjam <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" 
                           name="loan_date" 
                           id="loan_date" 
                           value="{{ old('loan_date', date('Y-m-d')) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('loan_date') border-rose-500 @enderror"
                           required>
                    @error('loan_date')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Batas Kembali -->
                <div>
                    <label for="due_date" class="block text-xs font-semibold text-slate-700 mb-1">
                        Batas Pengembalian (Jatuh Tempo) <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" 
                           name="due_date" 
                           id="due_date" 
                           value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('due_date') border-rose-500 @enderror"
                           required>
                    <p class="text-[11px] text-slate-400 mt-1">Standar peminjaman: 7 hari kalender.</p>
                    @error('due_date')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Catatan -->
            <div>
                <label for="notes" class="block text-xs font-semibold text-slate-700 mb-1">
                    Catatan / Keperluan Peminjaman (Opsional)
                </label>
                <textarea name="notes" 
                          id="notes" 
                          rows="2" 
                          placeholder="Contoh: Tugas makalah Biologi, lomba cerdas cermat, dll."
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('notes') border-rose-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('loans.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-md shadow-blue-500/20 active:scale-95 transition-all">
                    <i class="fa-solid fa-check mr-1.5"></i> Simpan Peminjaman
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
