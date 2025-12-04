@extends('user.layout.mobile')

@section('title', 'Detail Peminjaman')
@section('wrapperClass', 'onboarding-wrapper')

@section('content')

{{-- ======================================================== --}}
{{-- LOGIKA TOMBOL BACK --}}
{{-- ======================================================== --}}
@php
    // 1. Default arahnya ke History
    $backRoute = route('user.rentals.history');

    // 2. Cek apakah ada titipan pesan "from=profile" di URL?
    if(request()->query('from') == 'profile') {
        // Jika ada, ubah arahnya jadi ke Profile
        $backRoute = route('user.profile');
    }
@endphp

{{-- HEADER (BAGIAN INI YANG DIUBAH: mt-4 px-5 menjadi mt-2 px-4) --}}
<div class="flex items-center justify-between mb-6 mt-2 px-4">
    <div class="flex items-center gap-4">
        {{-- Ikon sudah diubah menjadi arrow_back dengan size 26px --}}
        <a href="{{ $backRoute }}" class="material-symbols-rounded text-[#2A2A2A] text-[26px]">arrow_back</a>
        <h1 class="text-[20px] font-bold text-[#2A2A2A]">Detail Peminjaman</h1>
    </div>
    {{-- Ikon kanan (more_vert) tetap dipertahankan karena mungkin fungsional --}}
    <span class="material-symbols-rounded text-[28px] text-[#2A2A2A]">more_vert</span>
</div>

<div class="px-5 pb-10">
    {{-- ************************************************* --}}
    {{-- Sisa konten di bawah ini tidak berubah.          --}}
    {{-- Konten di bawah header ini akan mengikuti padding --}}
    {{-- yang sudah ada yaitu px-5.                      --}}
    {{-- ************************************************* --}}

    {{-- NOMOR PEMINJAMAN --}}
    <div class="mb-6">
        <p class="text-[15px] font-semibold text-[#2A2A2A]">Nomor Peminjaman</p>
        <p class="text-[15px] font-medium text-[#6A6A6A] mt-1"># {{ $booking->id_booking }}</p>
    </div>

    {{-- TANGGAL PENGAJUAN --}}
    <div class="mb-6 space-y-3">
        <p class="text-[15px] font-semibold text-[#2A2A2A]">Tanggal Pengajuan</p>
        
        {{-- Hari & Tanggal --}}
        <div class="flex items-center gap-3 text-[#6A6A6A]">
            <span class="material-symbols-rounded text-[20px]">calendar_today</span>
            <span class="text-[15px] font-medium">
                {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('l, d F Y') }}
            </span>
        </div>

        {{-- Jam --}}
        <div class="flex items-center gap-3 text-[#6A6A6A]">
            <span class="material-symbols-rounded text-[20px]">schedule</span>
            <span class="text-[15px] font-medium">
                {{ \Carbon\Carbon::parse($booking->created_at)->format('H : i') }}
            </span>
        </div>

        {{-- Status --}}
        <div class="flex items-center gap-3 text-[#6A6A6A]">
            <span class="material-symbols-rounded text-[20px]">hourglass_top</span>
            <span class="text-[15px] font-medium">
                @if($booking->status == 'Pending') Menunggu Konfirmasi
                @elseif($booking->status == 'Approved') Disetujui (Sedang Dipinjam)
                @elseif($booking->status == 'Completed') Selesai
                @elseif($booking->status == 'Rejected') Ditolak
                @endif
            </span>
        </div>
    </div>

    {{-- TANGGAL PEMINJAMAN --}}
    <div class="mb-6">
        <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Tanggal Peminjaman</p>
        
        {{-- Hari & Tanggal (Start Time) --}}
        <div class="flex items-center gap-3 text-[#6A6A6A]">
            <span class="material-symbols-rounded text-[20px]">calendar_today</span>
            <span class="text-[15px] font-medium">
                {{ \Carbon\Carbon::parse($booking->start_time)->translatedFormat('l, d F Y') }}
            </span>
        </div>
        
        {{-- Jam (Start Time) --}}
        <div class="flex items-center gap-3 text-[#6A6A6A] mt-3">
            <span class="material-symbols-rounded text-[20px]">schedule</span>
            <span class="text-[15px] font-medium">
                {{ \Carbon\Carbon::parse($booking->start_time)->format('H : i') }} WIB
            </span>
        </div>
    </div>

    {{-- DETAIL PEMINJAMAN (Ruangan & Barang) --}}
    <div class="mb-8">
        <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Detail Peminjaman</p>
        
        {{-- List Ruangan --}}
        @foreach($ruangan as $r)
        <div class="mb-4">
            <p class="text-[13px] text-[#9A9A9A] mb-1">Ruangan</p>
            <div class="flex items-center gap-2">
                <span class="text-[15px] font-medium text-[#2A2A2A]">{{ $r->asset_name }}</span>
                {{-- Jam Pinjam --}}
                <span class="bg-[#F5F5F5] text-[#6A6A6A] text-[11px] px-2 py-0.5 rounded flex items-center gap-1 font-medium">
                    <span class="material-symbols-rounded text-[12px]">schedule</span>
                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                </span>
            </div>
        </div>
        @endforeach

        {{-- List Barang --}}
        @if($barang->isNotEmpty())
            <p class="text-[13px] text-[#9A9A9A] mb-1 mt-4">Barang</p>
            @foreach($barang as $b)
            <div class="flex justify-between items-center mb-2">
                <span class="text-[15px] font-medium text-[#2A2A2A]">{{ $b->asset_name }}</span>
                <span class="text-[13px] text-[#6A6A6A] font-medium">1 Buah</span>
            </div>
            @endforeach
        @else
            <p class="text-[13px] text-[#9A9A9A] mb-1 mt-4">Barang</p>
            <p class="text-[15px] font-medium text-[#2A2A2A]">-</p>
        @endif
    </div>

    {{-- ================================================= --}}
    {{-- LOGIKA TOMBOL FILE & PENGEMBALIAN --}}
    {{-- ================================================= --}}

    {{-- SKENARIO 3: STATUS SELESAI (Completed) --}}
    @if($booking->status == 'Completed')
        <div class="mb-8">
            <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Bukti Pengembalian</p>
            {{-- Tombol Foto (Read Only) --}}
            <div class="w-full border border-[#F26E21] text-[#F26E21] py-3 rounded-xl flex items-center justify-center gap-2 font-semibold">
                <span class="material-symbols-rounded">image</span>
                Foto
            </div>
        </div>
        {{-- Tombol Kembali ke Beranda --}}
        <a href="{{ route('user.home') }}" class="block w-full bg-[#F26E21] text-white text-center py-3 rounded-xl font-bold text-[15px] shadow-md shadow-orange-200/50">
            Kembali ke Beranda
        </a>

    {{-- SKENARIO 2: STATUS DISETUJUI (Approved) --}}
    @elseif($booking->status == 'Approved')
        <div class="mb-6">
            <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Dokumen</p>
            {{-- Tombol File Proposal --}}
            @if($booking->attachment)
                <a href="{{ asset('storage/' . $booking->attachment) }}" target="_blank"
                   class="w-full border border-[#F26E21] text-[#F26E21] py-3 rounded-xl flex items-center justify-center gap-2 font-semibold mb-4 hover:bg-[#FFF2E9]">
                    <span class="material-symbols-rounded">description</span>
                    File
                </a>
            @endif
            {{-- Tombol AJUKAN PENGEMBALIAN --}}
            <a href="{{ route('user.rentals.return.form', $booking->id_booking) }}" 
               class="block w-full bg-[#F26E21] text-white text-center py-3 rounded-xl font-bold text-[15px] shadow-md shadow-orange-200/50">
                Ajukan Pengembalian
            </a>
        </div>

    {{-- SKENARIO 1: STATUS MENUNGGU (Pending) / DITOLAK (Rejected) --}}
    @else
        <div class="mb-8">
            <p class="text-[15px] font-semibold text-[#2A2A2A] mb-3">Dokumen</p>
            {{-- Hanya Tombol File Proposal --}}
            @if($booking->attachment)
                <a href="{{ asset('storage/' . $booking->attachment) }}" target="_blank"
                   class="w-full border border-[#F26E21] text-[#F26E21] py-3 rounded-xl flex items-center justify-center gap-2 font-semibold hover:bg-[#FFF2E9]">
                    <span class="material-symbols-rounded">description</span>
                    File
                </a>
            @else
                <div class="w-full border border-[#E5E5E5] text-[#9A9A9A] py-3 rounded-xl flex items-center justify-center gap-2 font-medium italic bg-gray-50">
                    Tidak ada file
                </div>
            @endif
        </div>
        {{-- Tombol Kembali ke Beranda --}}
        <a href="{{ route('user.home') }}" class="block w-full bg-[#F26E21] text-white text-center py-3 rounded-xl font-bold text-[15px] shadow-md shadow-orange-200/50">
            Kembali ke Beranda
        </a>
    @endif

</div>

@endsection