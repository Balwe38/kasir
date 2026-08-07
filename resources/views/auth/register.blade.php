<x-guest-layout>
    <div class="min-h-screen flex flex-col md:flex-row bg-white">

        <!-- Kolom Kiri: Banner Hero Branding Apotek -->
        <div class="relative md:w-1/2 bg-slate-900 text-white p-8 md:p-12 flex flex-col justify-between overflow-hidden">
            <!-- Background Image Gedung/Ruang Apotek -->
            <div class="absolute inset-0 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1586015555751-63bb77f4322a?auto=format&fit=crop&q=80&w=1600"
                     alt="Apotek Background"
                     class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/90 to-transparent"></div>
            </div>

            <!-- Brand Logo / Header Kiri -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="p-2.5 bg-emerald-600 text-white rounded-xl shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.59 15.12a2 2 0 00-1.18.125l-.26.11a2 2 0 00-1.15 1.83V19a2 2 0 002 2h14a2 2 0 002-2v-1.745a2 2 0 00-.572-1.427zM12 3v8m-4-4h8" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-tight text-white block leading-tight">Apotek Sehat Utama</span>
                    <span class="text-xs text-slate-400 font-medium">Apoteker: apt. John Doe, S.Farm</span>
                </div>
            </div>

            <!-- Teks Informasi Pendaftaran Kiri -->
            <div class="relative z-10 my-auto py-12 space-y-4">
                <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-300 bg-emerald-950/80 border border-emerald-800/50 rounded-full">
                    Bergabung Bersama Kami
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold leading-tight text-white">
                    Buat Akun Baru
                </h1>
                <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-md">
                    Daftarkan akun Anda untuk mengakses fitur layanan farmasi, riwayat konsultasi, serta kemudahan transaksi obat secara terintegrasi.
                </p>
            </div>

            <!-- Footer Kiri -->
            <div class="relative z-10 text-xs text-slate-500">
                &copy; {{ date('Y') }} Apotek Sehat Utama. All rights reserved.
            </div>
        </div>

        <!-- Kolom Kanan: Form Input Register -->
        <div class="md:w-1/2 bg-white p-8 md:p-16 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto">

                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900">Registrasi Akun</h2>
                    <p class="text-sm text-slate-500 mt-1">Lengkapi data diri Anda di bawah ini</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-slate-700 font-medium" />
                        <x-text-input id="name"
                                      class="block mt-1.5 w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                      type="text"
                                      name="name"
                                      :value="old('name')"
                                      required autofocus autocomplete="name"
                                      placeholder="Nama Lengkap" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-medium" />
                        <x-text-input id="email"
                                      class="block mt-1.5 w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                      type="email"
                                      name="email"
                                      {{-- :value="old('email')" --}}
                                      required autocomplete="username"
                                      placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-medium" />
                        <x-text-input id="password"
                                      class="block mt-1.5 w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                      type="password"
                                      name="password"
                                      required autocomplete="new-password"
                                      placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-700 font-medium" />
                        <x-text-input id="password_confirmation"
                                      class="block mt-1.5 w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                      type="password"
                                      name="password_confirmation"
                                      required autocomplete="new-password"
                                      placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                    </div>

                    <!-- Tombol Register -->
                    <div class="pt-4">
                        <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-md shadow-emerald-600/20 transition duration-200 text-sm">
                            {{ __('Register') }}
                        </button>
                    </div>

                    <!-- Link ke Halaman Login -->
                    <p class="text-center text-xs text-slate-500 pt-3">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:underline">
                            {{ __('Already registered?') }}
                        </a>
                    </p>
                </form>
            </div>
        </div>

    </div>
</x-guest-layout>
