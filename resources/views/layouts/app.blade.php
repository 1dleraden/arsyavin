<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Sekolah') — SMKN 1 Ciomas</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN for guaranteed styling in any environment (including XAMPP without Vite watcher) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome Icons for clean UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col text-slate-800 antialiased selection:bg-blue-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 w-full glass-header border-b border-slate-200/80 shadow-xs no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-book-open-reader text-lg"></i>
                        </div>
                        <div>
                            <span class="font-extrabold text-lg tracking-tight bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-800 bg-clip-text text-transparent">SMKN 1 Ciomas</span>
                            <span class="block text-[11px] font-semibold tracking-wider uppercase text-blue-600">Perpustakaan Sekolah</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70' }}">
                        <i class="fa-solid fa-chart-pie text-xs {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('books.index') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('books.*') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70' }}">
                        <i class="fa-solid fa-book text-xs {{ request()->routeIs('books.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        Katalog Buku
                    </a>
                    <a href="{{ route('loans.index') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('loans.*') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70' }}">
                        <i class="fa-solid fa-handshake text-xs {{ request()->routeIs('loans.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        Peminjaman
                    </a>
                    <a href="{{ route('reports.index') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70' }}">
                        <i class="fa-solid fa-file-invoice text-xs {{ request()->routeIs('reports.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        Laporan Rekap
                    </a>
                </nav>

                <!-- Action Button -->
                <div class="hidden md:flex items-center gap-2.5">
                    <a href="{{ route('loans.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:scale-95 shadow-sm shadow-blue-500/30 transition-all duration-150">
                        <i class="fa-solid fa-plus text-xs"></i>
                        Pinjam Buku
                    </a>
                    <a href="{{ route('books.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 active:scale-95 shadow-2xs transition-all duration-150">
                        <i class="fa-solid fa-folder-plus text-xs text-slate-500"></i>
                        Tambah Buku
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden">
                    <button id="mobileMenuBtn" type="button" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 pt-2 border-t border-slate-200 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-chart-pie mr-2 text-slate-400"></i> Dashboard
                </a>
                <a href="{{ route('books.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('books.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-book mr-2 text-slate-400"></i> Katalog Buku
                </a>
                <a href="{{ route('loans.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('loans.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-handshake mr-2 text-slate-400"></i> Peminjaman
                </a>
                <a href="{{ route('reports.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <i class="fa-solid fa-file-invoice mr-2 text-slate-400"></i> Laporan Rekap
                </a>
                <div class="pt-2 flex flex-col gap-2">
                    <a href="{{ route('loans.create') }}" class="w-full text-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-blue-600">
                        + Pinjam Buku Baru
                    </a>
                    <a href="{{ route('books.create') }}" class="w-full text-center px-4 py-2 rounded-lg text-sm font-medium text-slate-700 bg-white border border-slate-200">
                        + Tambah Data Buku
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div id="flashAlert" class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-2xs no-print transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('flashAlert').remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="flashError" class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-2xs no-print transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('flashError').remove()" class="text-rose-500 hover:text-rose-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div id="flashInfo" class="mb-6 p-4 rounded-xl bg-sky-50 border border-sky-200 text-sky-800 flex items-center justify-between shadow-2xs no-print transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-500 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <span class="text-sm font-medium">{{ session('info') }}</span>
                </div>
                <button onclick="document.getElementById('flashInfo').remove()" class="text-sky-500 hover:text-sky-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 shadow-2xs no-print">
                <div class="flex items-center gap-2 mb-2 font-semibold text-sm">
                    <i class="fa-solid fa-circle-exclamation text-amber-600"></i>
                    <span>Terdapat beberapa kesalahan input:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-amber-700 pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Yield -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white py-6 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-md bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">SMK</div>
                <span class="font-semibold text-slate-700">Perpustakaan SMKN 1 Ciomas &copy; {{ date('Y') }}</span>
                <span>— Sistem Informasi Perpustakaan Sekolah</span>
            </div>
            <div class="flex items-center gap-4">
                <span>Versi 1.0 (Laravel {{ Illuminate\Foundation\Application::VERSION }})</span>
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span class="text-emerald-700 font-medium">Status: Aktif</span>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Toggle mobile menu
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
