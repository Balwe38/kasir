<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" x-data="{ openCreate: {{ $errors->any() && old('_form') == 'create' ? 'true' : 'false' }} }">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Akun') }}
            </h2>

            <button
                @click="openCreate = true"
                class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 transition">
                + Tambah Akun
            </button>

            {{-- Modal Tambah Akun --}}
            <div
                x-show="openCreate"
                x-cloak
                @keydown.escape.window="openCreate = false"
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 px-4"
                style="display: none;">

                <div
                    @click.outside="openCreate = false"
                    class="w-full max-w-md rounded-xl bg-white p-6 shadow-lg">

                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-semibold text-gray-800">Tambah Akun</h3>
                        <button @click="openCreate = false" class="text-gray-400 hover:text-gray-600">
                            &times;
                        </button>
                    </div>

                    <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="_form" value="create">

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('_form') == 'create' ? old('name') : '' }}"
                                placeholder="Masukkan nama lengkap"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 @error('name') border-red-400 @enderror">
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('_form') == 'create' ? old('email') : '' }}"
                                placeholder="nama@gmail.com"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 @error('email') border-red-400 @enderror">
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Minimal 8 karakter"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 @error('password') border-red-400 @enderror">
                            @error('password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Konfirmasi Password
                            </label>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select
                                id="role"
                                name="role"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 @error('role') border-red-400 @enderror">
                                <option value="kasir" {{ old('_form') == 'create' && old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="admin" {{ old('_form') == 'create' && old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button
                                type="button"
                                @click="openCreate = false"
                                class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 rounded-lg bg-teal-600 text-sm font-semibold text-white hover:bg-teal-700 transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row md:justify-between md:items-center gap-3">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Data Pengguna
                        </h3>

                        <p class="text-sm text-gray-500">
                            Daftar akun Admin dan Kasir.
                        </p>
                    </div>

                    {{-- Search --}}
                    <form method="GET">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama / email..."
                            class="rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 w-72">
                    </form>

                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    No
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Nama
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Email
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Role
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Dibuat
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">

                            @forelse($users as $user)

                                <tr
                                    class="hover:bg-gray-50 transition"
                                    x-data="{ openEdit: {{ $errors->any() && old('_form') == 'edit' && old('user_id') == $user->id ? 'true' : 'false' }} }">

                                    <td class="px-6 py-4">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center font-bold text-teal-700">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <div class="font-semibold text-gray-800">

                                                    {{ $user->name }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-4 text-gray-600">

                                        {{ $user->email }}

                                    </td>

                                    <td class="px-6 py-4 text-center">

                                        @if($user->role == 'admin')

                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                                Admin
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                Kasir
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-center text-gray-500 text-sm">

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            {{-- Edit --}}
                                            <button
                                                @click="openEdit = true"
                                                type="button"
                                                class="px-3 py-2 rounded-lg bg-yellow-400 text-white hover:bg-yellow-500 transition">

                                                Edit

                                            </button>

                                            {{-- Delete --}}
                                            <form
                                                action="{{ route('users.destroy', $user->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus akun ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="px-3 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">

                                                    Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                    {{-- Modal Edit Akun --}}
                                    <template x-teleport="body">
                                        <div
                                            x-show="openEdit"
                                            x-cloak
                                            @keydown.escape.window="openEdit = false"
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 px-4"
                                            style="display: none;">

                                            <div
                                                @click.outside="openEdit = false"
                                                class="w-full max-w-md rounded-xl bg-white p-6 shadow-lg">

                                                <div class="flex items-center justify-between mb-5">
                                                    <h3 class="text-lg font-semibold text-gray-800">Edit Akun</h3>
                                                    <button @click="openEdit = false" class="text-gray-400 hover:text-gray-600">
                                                        &times;
                                                    </button>
                                                </div>

                                                <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="_form" value="edit">
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            value="{{ old('user_id') == $user->id ? old('name') : $user->name }}"
                                                            placeholder="Masukkan nama lengkap"
                                                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 @error('name') border-red-400 @enderror">
                                                        @error('name')
                                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                        <input
                                                            type="email"
                                                            name="email"
                                                            value="{{ old('user_id') == $user->id ? old('email') : $user->email }}"
                                                            placeholder="nama@gmail.com"
                                                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 @error('email') border-red-400 @enderror">
                                                        @error('email')
                                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                                            Password <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>
                                                        </label>
                                                        <input
                                                            type="password"
                                                            name="password"
                                                            placeholder="Minimal 8 karakter"
                                                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 @error('password') border-red-400 @enderror">
                                                        @error('password')
                                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                                            Konfirmasi Password
                                                        </label>
                                                        <input
                                                            type="password"
                                                            name="password_confirmation"
                                                            placeholder="Ulangi password baru"
                                                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                                        <select
                                                            name="role"
                                                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 @error('role') border-red-400 @enderror">
                                                            @php
                                                                $selectedRole = old('user_id') == $user->id ? old('role') : $user->role;
                                                            @endphp
                                                            <option value="kasir" {{ $selectedRole == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                                            <option value="admin" {{ $selectedRole == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        </select>
                                                        @error('role')
                                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="flex justify-end gap-3 pt-2">
                                                        <button
                                                            type="button"
                                                            @click="openEdit = false"
                                                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                                                            Batal
                                                        </button>
                                                        <button
                                                            type="submit"
                                                            class="px-4 py-2 rounded-lg bg-teal-600 text-sm font-semibold text-white hover:bg-teal-700 transition">
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </template>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="py-10 text-center text-gray-500">

                                        Belum ada data pengguna.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                @if(method_exists($users, 'links'))

                    <div class="px-6 py-4 border-t">

                        {{ $users->links() }}

                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>