@extends('user.layout.mobile')

@section('title', 'Ubah Kata Sandi')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold mb-6 text-gray-800">Ubah Kata Sandi</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('user.settings.update.password') }}">
        @csrf
        @method('PUT') {{-- PENTING: Menggunakan metode PUT seperti yang didefinisikan di routes/web.php --}}

        <div class="mb-4">
            <label for="current_password" class="block text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
            <input type="password" id="current_password" name="current_password" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                   placeholder="Verifikasi kata sandi lama Anda">
            @error('current_password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
            <input type="password" id="password" name="password" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                   placeholder="Minimal 8 karakter">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:ring-offset-2 focus:border-indigo-500 sm:text-sm"
                   placeholder="Ulangi kata sandi baru">
        </div>

        <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Ubah Kata Sandi
        </button>
    </form>
</div>
@endsection