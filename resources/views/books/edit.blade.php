@extends('layouts.app')

@section('title', 'Edit Buku — ' . $book->title)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('books.show', $book) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Kembali ke Detail Buku
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Edit Data Buku</h1>
                    <p class="text-xs text-slate-500">Perbarui data buku dengan kode <span class="font-mono font-semibold">{{ $book->code }}</span>.</p>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                Tersedia: {{ $book->available_stock }}/{{ $book->stock }}
            </span>
        </div>

        <form action="{{ route('books.update', $book) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Data Utama -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Pokok</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Kode Buku -->
                    <div>
                        <label for="code" class="block text-xs font-semibold text-slate-700 mb-1">
                            Kode Buku <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="code" 
                               id="code" 
                               value="{{ old('code', $book->code) }}" 
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-mono uppercase focus:ring-2 focus:ring-blue-500 focus:outline-none @error('code') border-rose-500 @enderror"
                               required>
                        @error('code')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category" class="block text-xs font-semibold text-slate-700 mb-1">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select name="category" id="category" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white @error('category') border-rose-500 @enderror" required>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $book->category) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label for="year" class="block text-xs font-semibold text-slate-700 mb-1">
                            Tahun Terbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" 
                               name="year" 
                               id="year" 
                               value="{{ old('year', $book->year) }}" 
                               min="1900" 
                               max="{{ date('Y') + 1 }}" 
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('year') border-rose-500 @enderror"
                               required>
                        @error('year')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Judul Buku -->
                <div>
                    <label for="title" class="block text-xs font-semibold text-slate-700 mb-1">
                        Judul Buku <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $book->title) }}" 
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('title') border-rose-500 @enderror"
                           required>
                    @error('title')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 2: Penulis & Penerbit -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kepenulisan & Penerbit</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Penulis -->
                    <div>
                        <label for="author" class="block text-xs font-semibold text-slate-700 mb-1">
                            Penulis / Pengarang <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="author" 
                               id="author" 
                               value="{{ old('author', $book->author) }}" 
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('author') border-rose-500 @enderror"
                               required>
                        @error('author')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label for="publisher" class="block text-xs font-semibold text-slate-700 mb-1">
                            Penerbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="publisher" 
                               id="publisher" 
                               value="{{ old('publisher', $book->publisher) }}" 
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('publisher') border-rose-500 @enderror"
                               required>
                        @error('publisher')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Inventaris & Lokasi -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Inventaris & Penempatan</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Stok -->
                    <div>
                        <label for="stock" class="block text-xs font-semibold text-slate-700 mb-1">
                            Total Stok Eksemplar <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" 
                               name="stock" 
                               id="stock" 
                               value="{{ old('stock', $book->stock) }}" 
                               min="1" 
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('stock') border-rose-500 @enderror"
                               required>
                        <p class="text-[11px] text-slate-400 mt-1">Buku sedang dipinjam: {{ $book->stock - $book->available_stock }}</p>
                        @error('stock')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi Rak -->
                    <div class="sm:col-span-2">
                        <label for="shelf_location" class="block text-xs font-semibold text-slate-700 mb-1">
                            Lokasi Rak / Lemari
                        </label>
                        <input type="text" 
                               name="shelf_location" 
                               id="shelf_location" 
                               value="{{ old('shelf_location', $book->shelf_location) }}" 
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('shelf_location') border-rose-500 @enderror">
                        @error('shelf_location')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- URL Cover -->
                <div>
                    <label for="cover_url" class="block text-xs font-semibold text-slate-700 mb-1">
                        URL Gambar Sampul (Opsional)
                    </label>
                    <input type="url" 
                           name="cover_url" 
                           id="cover_url" 
                           value="{{ old('cover_url', $book->cover_url) }}" 
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('cover_url') border-rose-500 @enderror">
                    @error('cover_url')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-xs font-semibold text-slate-700 mb-1">
                        Sinopsis / Keterangan Singkat
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="3" 
                              class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('description') border-rose-500 @enderror">{{ old('description', $book->description) }}</textarea>
                    @error('description')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('books.show', $book) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold shadow-md shadow-amber-500/20 active:scale-95 transition-all">
                    <i class="fa-solid fa-check mr-1.5"></i> Perbarui Data
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
