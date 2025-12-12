<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'E-Commerce') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="CostumeID" class="h-12 w-auto object-contain">
                    </a>
                </div>

                <div class="hidden sm:flex flex-1 px-8">
                    <div class="relative w-full">
                        <input type="text" class="w-full border-gray-300 rounded-full pl-5 pr-12 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50" placeholder="Cari kostum anime, superhero...">
                        <button class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-gray-500 hover:text-indigo-600 rounded-full hover:bg-gray-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">
                    
                    @auth
                        <a href="{{ route('wallet.topup') }}" class="hidden md:flex items-center gap-2 bg-indigo-50 px-4 py-2 rounded-full border border-indigo-100 hover:bg-indigo-100 transition group">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <div class="flex flex-col items-start leading-none">
                                <span class="text-[10px] text-gray-500 font-medium">Saldo Saya</span>
                                <span class="text-sm font-bold text-indigo-700 group-hover:text-indigo-800">
                                    Rp {{ number_format(Auth::user()->userBalance->balance ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </a>
                    @endauth

                    <button onclick="alert('Keranjang Coming Soon!')" class="relative text-gray-500 hover:text-indigo-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">0</span>
                    </button>

                    @auth
                        <div class="relative ml-2" x-data="{ open: false }">
                            <button @click="open = ! open" class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                                <img class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}" />
                                <div class="hidden md:block text-left">
                                    <div class="text-xs text-gray-400">Halo,</div>
                                    <div class="font-bold text-gray-700 leading-none">{{ Str::limit(Auth::user()->name, 10) }}</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg py-2 ring-1 ring-black ring-opacity-5 z-50 transform origin-top-right transition-all" style="display: none;">
                                <div class="px-4 py-3 border-b border-gray-100 md:hidden">
                                    <p class="text-sm text-gray-500">Login sebagai</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-indigo-600 font-bold mt-1">Saldo: Rp {{ number_format(Auth::user()->userBalance->balance ?? 0, 0, ',', '.') }}</p>
                                </div>

                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">Admin Dashboard</a>
                                @endif
                                
                                {{-- PERBAIKAN DI SINI --}}
                                {{-- Cek apakah user punya toko (Verified ataupun belum) --}}
                                @if(Auth::user()->store)
                                    <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                        Toko Saya
                                    </a>
                                @else
                                    <a href="{{ route('store.register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                        Buka Toko Gratis
                                    </a>
                                @endif
                                {{-- AKHIR PERBAIKAN --}}

                                <div class="border-t border-gray-100 my-1"></div>

                                <a href="{{ route('history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600 flex justify-between items-center">
                                    Riwayat Belanja
                                </a>
                                <a href="{{ route('wallet.topup') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600 flex justify-between items-center">
                                    Topup Saldo
                                    <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold">+</span>
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">Pengaturan Akun</a>
                                
                                <div class="border-t border-gray-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-3 text-sm">
                            <a href="{{ route('login') }}" class="px-5 py-2.5 border border-indigo-600 text-indigo-600 rounded-full hover:bg-indigo-50 font-bold transition">Masuk</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 font-bold shadow-md hover:shadow-lg transition">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen pb-10">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white py-12 mt-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-1">
                <img src="{{ asset('assets/images/logo.png') }}" alt="CostumeID" class="h-12 w-auto mb-4 grayscale opacity-80 hover:opacity-100 transition">
                <p class="text-gray-400 text-sm leading-relaxed">
                    Platform jual beli kostum nomor #1 di Indonesia. Temukan karakter impianmu dan jadilah bintang di setiap acara.
                </p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4 text-white">Layanan</h4>
                <ul class="text-gray-400 text-sm space-y-3">
                    <li><a href="#" class="hover:text-indigo-400 transition">Pusat Bantuan</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Cara Pembelian</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Pengiriman</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Cara Pengembalian</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4 text-white">Tentang Kami</h4>
                <ul class="text-gray-400 text-sm space-y-3">
                    <li><a href="#" class="hover:text-indigo-400 transition">About Us</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Karir</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Blog</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4 text-white">Hubungi Kami</h4>
                <p class="text-gray-400 text-sm mb-2">Email: pusatkostum@gmail.com</p>
                <p class="text-gray-400 text-sm mb-4">WhatsApp: +62 812-3456-7890</p>
                <div class="flex gap-4">
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600 transition text-white">IG</a>
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600 transition text-white">FB</a>
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600 transition text-white">TW</a>
                </div>
            </div>
        </div>
        <div class="text-center text-gray-600 text-sm mt-12 pt-8 border-t border-gray-800">
            &copy; 2025 PusatKostum. Hak Cipta Dilindungi Undang-Undang.
        </div>
    </footer>
</body>
</html>