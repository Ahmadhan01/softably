@extends('layouts.sidebar-seller') {{-- Pastikan path ini benar sesuai lokasi sidebar-seller.blade.php --}}

@section('isi')
<style>
    /* Sertakan kembali CSS dari softpay-seller.blade.php atau buat terpisah jika mau */
    .softpay-balance-card {
        background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%); /* Ubah gradient menjadi biru cerah */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); /* Sedikit shadow */
        border-radius: 1rem;
        padding: 2rem;
        color: white;
        text-align: center;
    }
    .softpay-balance-card h2 {
        font-size: 1.2rem;
        color: #E0E7FF; /* Warna teks lebih terang untuk kontras */
    }
    .softpay-balance-card p {
        font-size: 3rem; /* Large font for balance */
        font-weight: bold;
        margin-top: 0.5rem;
        color: white; /* Warna saldo menjadi putih */
    }
</style>

{{-- Kontainer utama untuk halaman --}}
<div class="bg-[#F8FAFC] min-h-screen text-gray-800 p-6 rounded-lg shadow-md"> {{-- Ubah background utama dan teks, tambahkan padding, rounded, shadow --}}
    <div class="max-w-xl mx-auto space-y-8">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Tarik Dana SoftPay</h1> {{-- Ubah warna teks --}}

        <div class="softpay-balance-card mb-8">
            <h2>Saldo SoftPay Anda Saat Ini</h2>
            <p class="text-4xl">Rp {{ number_format($sellerSoftpayBalance ?? 0, 0, ',', '.') }},00</p> {{-- Perbesar font saldo --}}
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Form Penarikan Dana</h3> {{-- Ubah warna teks --}}

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded-lg mb-4"> {{-- Ubah warna alert success --}}
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded-lg mb-4"> {{-- Ubah warna alert error --}}
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('seller.softpay.processWithdraw') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Penarikan (Min. Rp 10.000)</label> {{-- Ubah warna teks label --}}
                    <input type="number" name="amount" id="amount"
                           class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" {{-- Ubah styling input --}}
                           min="10000" step="1000" required>
                    @error('amount')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tambahkan field lain untuk detail bank --}}
                <div class="mb-4">
                    <label for="bank_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Bank</label> {{-- Ubah warna teks label --}}
                    <input type="text" name="bank_name" id="bank_name"
                           class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" {{-- Ubah styling input --}}
                           placeholder="Contoh: BCA, Mandiri" required>
                </div>
                <div class="mb-4">
                    <label for="account_number" class="block text-gray-700 text-sm font-bold mb-2">Nomor Rekening</label> {{-- Ubah warna teks label --}}
                    <input type="text" name="account_number" id="account_number"
                           class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" {{-- Ubah styling input --}}
                           placeholder="Contoh: 1234567890" required>
                </div>
                <div class="mb-6">
                    <label for="account_holder_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Pemilik Rekening</label> {{-- Ubah warna teks label --}}
                    <input type="text" name="account_holder_name" id="account_holder_name"
                           class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" {{-- Ubah styling input --}}
                           placeholder="Contoh: Nama Anda" required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                        Ajukan Penarikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection