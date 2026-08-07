<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Akun') }}
            </h2>

            <a href="{{ route('users.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-lg text-white hover:bg-gray-700 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg">

                <div class="px-6 py-5 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Form Edit Akun
                    </h3>
                    <p class="text-sm text-gray-500">
                        Perbarui data pengguna.
                    </p>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Nama --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">

                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">

                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Role
                            </label>

                            <select
                                name="role"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">

                                <option value="admin"
                                    {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="kasir"
                                    {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>
                                    Kasir
                                </option>

                            </select>

                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password Baru --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru
                            </label>

                            <input
                                type="password"
                                name="password"
                                placeholder="Kosongkan jika tidak ingin diubah"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">

                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password Baru
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="Ulangi password baru"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 mt-8">

                        <a href="{{ route('users.index') }}"
                            class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 transition">
                            Update Akun
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>.