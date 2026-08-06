<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotek HealthCare - Layanan Farmasi & Obat Terpercaya</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS keyframes untuk animasi masuk yang mulus -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-enter {
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body class="bg-white text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header
        class="w-full max-w-7xl mx-auto px-6 py-5 flex items-center justify-between border-b border-slate-100 animate-enter">
        <div class="flex items-center gap-3 group cursor-pointer">
            <div
                class="p-2 bg-emerald-600 text-white rounded-lg shadow-sm group-hover:scale-105 transition-transform duration-300">
                <!-- Icon Mortar & Pestle / Obat -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.59 15.12a2 2 0 00-1.18.125l-.26.11a2 2 0 00-1.15 1.83V19a2 2 0 002 2h14a2 2 0 002-2v-1.745a2 2 0 00-.572-1.427zM12 3v8m-4-4h8" />
                </svg>
            </div>
            <div>
                <span class="text-xl font-bold tracking-tight text-slate-900 block leading-tight">Apotek Sehat
                    Utama</span>
                <span class="text-xs text-slate-500 font-medium">Apoteker: apt. John Doe, S.Farm</span>
            </div>
        </div>

        <!-- Auth Navigation -->
        <nav class="flex items-center gap-2">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal font-medium transition-all duration-200">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal font-medium transition-all duration-200">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal font-medium transition-all duration-200">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <!-- Main Content -->
    <main class="w-full flex-1">

        <!-- Hero Section dengan Latar Gedung Apotek -->
        <section class="relative bg-slate-900 text-white py-24 md:py-32 overflow-hidden">
            <!-- Gambar Latar Gedung Apotek dengan efek zoom halus -->
            <div class="absolute inset-0 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1586015555751-63bb77f4322a?auto=format&fit=crop&q=80&w=1600"
                    alt="Gedung Apotek"
                    class="w-full h-full object-cover object-center opacity-25 scale-105 animate-pulse transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/80 to-transparent"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 opacity-0 animate-enter" style="animation-delay: 150ms;">
                    <span
                        class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-300 bg-emerald-950/80 border border-emerald-800/50 rounded-full">
                        Pelayanan Farmasi & Konsultasi Obat
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight text-white">
                        Solusi Obat Terpercaya & Pelayanan Apoteker Profesional
                    </h1>
                    <p class="text-lg text-slate-300">
                        Kami menyediakan obat-obatan berkualitas, racikan resep dokter yang akurat, serta konsultasi
                        penggunaan obat yang aman untuk keluarga Anda.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-4">
                        <a href="#about"
                            class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-lg shadow-lg shadow-emerald-900/20 transition-all duration-300 hover:-translate-y-0.5">
                            Tentang Saya
                        </a>
                        <a href="#services"
                            class="px-6 py-3 border border-slate-600 hover:bg-slate-800 text-white font-medium rounded-lg transition-all duration-300">
                            Layanan Obat
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Me Section -->
        <section id="about" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="max-w-3xl mx-auto text-center space-y-3 mb-16 opacity-0 animate-enter"
                    style="animation-delay: 300ms;">
                    <span class="text-emerald-600 font-semibold text-sm uppercase tracking-wider">Profil Apoteker</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900">About Me</h2>
                    <div class="w-16 h-1 bg-emerald-600 mx-auto rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">
                    <!-- Penjelasan About Me -->
                    <div class="md:col-span-2 space-y-4 text-slate-600 leading-relaxed text-base opacity-0 animate-enter"
                        style="animation-delay: 450ms;">
                        <p>
                            Apotek ini merupakan fasilitas pelayanan kefarmasian yang menyediakan berbagai jenis
                            obat-obatan, baik obat bebas, obat bebas terbatas, obat keras dengan resep dokter, maupun
                            obat racikan sesuai resep dari tenaga medis. Dengan didukung oleh apoteker dan tenaga teknis
                            kefarmasian yang berkompeten, setiap proses peracikan obat dilakukan secara teliti,
                            higienis, dan mengikuti standar pelayanan kefarmasian yang berlaku.</p>Lorem ipsu
                        <p>
                            Selain melayani penebusan resep dokter, apotek ini juga menyediakan layanan konsultasi
                            mengenai penggunaan obat, dosis, cara penyimpanan, serta informasi mengenai efek samping dan
                            interaksi obat. Seluruh obat yang tersedia dipastikan berasal dari distributor resmi
                            sehingga kualitas, keamanan, dan keasliannya tetap terjamin.</p>
                        <p>
                            Untuk obat racikan, setiap resep diproses secara individual sesuai petunjuk dokter dengan
                            memperhatikan ketepatan komposisi, dosis, dan bentuk sediaan yang dibutuhkan pasien. Proses
                            peracikan dilakukan menggunakan peralatan yang bersih dan sesuai standar untuk memastikan
                            mutu serta keamanan obat yang diberikan.</p>
                    </div>

                    <!-- Ringkasan Informasi / Stats -->
                    <div class="space-y-4 opacity-0 animate-enter" style="animation-delay: 600ms;">
                        <div
                            class="p-6 bg-slate-50 rounded-xl border border-slate-200/80 shadow-sm hover:border-emerald-300 hover:shadow-md transition-all duration-300">
                            <h3 class="text-3xl font-bold text-emerald-600">10+ Tahun</h3>
                            <p class="text-sm font-medium text-slate-600 mt-1">Pengalaman Praktik Apoteker</p>
                        </div>
                        <div
                            class="p-6 bg-slate-50 rounded-xl border border-slate-200/80 shadow-sm hover:border-emerald-300 hover:shadow-md transition-all duration-300">
                            <h3 class="text-3xl font-bold text-emerald-600">100% Asli</h3>
                            <p class="text-sm font-medium text-slate-600 mt-1">Jaminan Kualitas Obat & Resep</p>
                        </div>
                        <div
                            class="p-6 bg-slate-50 rounded-xl border border-slate-200/80 shadow-sm hover:border-emerald-300 hover:shadow-md transition-all duration-300">
                            <h3 class="text-3xl font-bold text-emerald-600">SIPA Valid</h3>
                            <p class="text-sm font-medium text-slate-600 mt-1">Surat Izin Praktik Apoteker Terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="w-full bg-slate-50 border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        &copy; {{ date('Y') }} Apotek Sehat Utama - apt. John Doe, S.Farm. All rights reserved.
    </footer>

</body>

</html>
