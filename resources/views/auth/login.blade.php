<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CostumeID</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:flex lg:w-1/2 bg-indigo-900 relative justify-center items-center overflow-hidden">
            <img src="https://images.unsplash.com/photo-1531300185372-b7cbe2eddf0b?q=80&w=1974&auto=format&fit=crop" 
                 alt="Cosplay Costume" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60">
            
            <div class="relative z-10 text-center px-10">
                <h2 class="text-4xl font-extrabold text-white mb-4 tracking-wide">Welcome Back!</h2>
                <p class="text-indigo-200 text-lg">
                    Masuk untuk melanjutkan petualangan kostummu dan cek status pesanan terbaru.
                </p>
            </div>
            
            {{-- <div class="absolute bottom-0 left-0 transform translate-y-1/2 -translate-x-1/2">
                <svg width="400" height="400" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#4F46E5" d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,79.6,-46.9C87.4,-34.7,90.1,-20.4,85.8,-8.3C81.5,3.8,70.2,13.7,60.9,23.5C51.6,33.2,44.3,42.8,35.2,50.6C26.1,58.4,15.2,64.4,3.2,67.8C-8.8,71.2,-21.9,72,-33.4,66.8C-44.9,61.6,-54.8,50.4,-63.3,38.1C-71.8,25.8,-78.9,12.4,-78.3,0.3C-77.7,-11.8,-69.4,-22.6,-59.6,-32.1C-49.8,-41.6,-38.5,-49.8,-26.8,-58.3C-15.1,-66.8,-3,-75.6,10.2,-78.9C23.4,-82.2,46.8,-80,44.7,-76.4Z" transform="translate(100 100)" />
                </svg>
            </div> --}}
        </div>

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                
                <div class="lg:hidden text-center mb-8">
                    <a href="/" class="text-3xl font-bold text-indigo-600 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        CostumeID
                    </a>
                </div>

                <div>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Masuk ke Akun</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Atau
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            daftar akun baru gratis
                        </a>
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="mt-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Alamat Email
                            </label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                    class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Kata Sandi
                                </label>
                                @if (Route::has('password.request'))
                                    <div class="text-sm">
                                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                            Lupa kata sandi?
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                    class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                                Masuk Sekarang
                            </button>
                        </div>
                    </form>

                    <div class="mt-6">
                        <a href="{{ route('home') }}" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            ← Kembali ke Beranda
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>