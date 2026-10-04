@extends('layouts.app')

@section('title', 'Katalog Buku Perpustakaan')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Katalog Buku Perpustakaan</h1>
            <p class="text-sm text-slate-500">Kelola data inventaris buku pelajaran, fiksi, dan literatur sekolah.</p>
        </div>
        <a href="{{ route('books.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-500/30 transition-all self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah Buku Baru
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
        <form action="{{ route('books.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-center">
            
            <!-- Search input -->
            <div class="relative flex-1 w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari judul buku, penulis, penerbit, atau kode buku..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <!-- Category Filter -->
            <div class="w-full md:w-56 shrink-0">
                <select name="category" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-700 bg-white">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="flex items-center gap-2 w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-4 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-colors">
                    Filter
                </button>
                @if(request('search') || (request('category') && request('category') !== 'all'))
                    <a href="{{ route('books.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-semibold hover:bg-slate-200 transition-colors" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Book Grid Cards -->
    @if($books->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-book"></i>
            </div>
            <h3 class="text-base font-bold text-slate-800">Tidak ada buku ditemukan</h3>
            <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Coba ubah kata kunci pencarian atau bersihkan filter kategori Anda.</p>
            <a href="{{ route('books.index') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100">
                <i class="fa-solid fa-rotate-left"></i> Reset Filter
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($books as $book)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col group">
                    
                    <!-- Top Info Header with Image -->
                    <div class="p-5 flex gap-4 flex-1">
                        
                        <!-- Thumbnail Cover -->
                        <div class="w-20 h-28 shrink-0 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shadow-2xs relative">
                            @if($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&auto=format&fit=crop&q=80';">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-slate-200 to-slate-100 text-slate-400 p-2 text-center">
                                    <i class="fa-solid fa-book text-2xl mb-1"></i>
                                    <span class="text-[9px] font-mono leading-tight">{{ $book->code }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0 flex flex-col">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold font-mono tracking-wider bg-slate-100 text-slate-700">
                                    {{ $book->code }}
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-700">
                                    {{ $book->category }}
                                </span>
                            </div>

                            <a href="{{ route('books.show', $book) }}" class="font-bold text-slate-900 text-sm line-clamp-2 hover:text-blue-600 transition-colors">
                                {{ $book->title }}
                            </a>

                            <div class="text-xs text-slate-500 mt-1 line-clamp-1">
                                <i class="fa-solid fa-pen-nib text-[10px] mr-1 text-slate-400"></i>{{ $book->author }}
                            </div>

                            <div class="text-xs text-slate-400 mt-auto pt-2 flex items-center justify-between">
                                <span>{{ $book->publisher }} ({{ $book->year }})</span>
                                @if($book->shelf_location)
                                    <span class="text-[11px] font-medium text-slate-600 bg-slate-50 px-1.5 py-0.5 rounded">
                                        <i class="fa-solid fa-location-dot text-[10px] text-amber-500"></i> {{ $book->shelf_location }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Bar (Stock & Actions) -->
                    <div class="px-5 py-3 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between gap-2 text-xs">
                        
                        <!-- Stock Status -->
                        <div>
                            @if($book->available_stock > 0)
                                <span class="inline-flex items-center gap-1 font-semibold text-emerald-700">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Tersedia {{ $book->available_stock }}/{{ $book->stock }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 font-semibold text-rose-600">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    Stok Habis (0/{{ $book->stock }})
                                </span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-1">
                            @if($book->available_stock > 0)
                                <a href="{{ route('loans.create', ['book_id' => $book->id]) }}" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Pinjamkan Buku Ini">
                                    <i class="fa-solid fa-handshake"></i>
                                </a>
                            @endif
                            <a href="{{ route('books.show', $book) }}" class="p-1.5 text-slate-600 hover:text-slate-900 hover:bg-slate-200/60 rounded-lg transition-colors" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('books.edit', $book) }}" class="p-1.5 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku \'{{ $book->title }}\'?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $books->links() }}
        </div>
    @endif

</div>
@endsection
