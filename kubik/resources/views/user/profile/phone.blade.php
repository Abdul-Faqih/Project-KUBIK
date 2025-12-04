@extends('user.layout.mobile')

@section('title', 'Ubah Nomor Telepon')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold mb-6 text-gray-800">Ubah Nomor Telepon</h1>

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

    <form method="POST" action="{{ route('user.settings.update.phone') }}">
        @csrf
        @method('PUT') {{-- PENTING: Menggunakan metode PUT seperti yang didefinisikan di routes/web.php --}}

        <div class="mb-4">
            <label for="current_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon Saat Ini</label>
            <input type="text" id="current_phone" value="{{ $user->phone_number ?? 'Belum Diatur' }}" disabled
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div class="mb-6">
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon Baru</label>
            <input type="tel" id="phone_number" name="phone_number" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                   placeholder="Masukkan nomor telepon baru Anda" value="{{ old('phone_number') }}">
            @error('phone_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Simpan Nomor Telepon Baru
        </button>
    </form>
</div>
@endsection