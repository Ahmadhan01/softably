@extends('layouts.sidebar-seller')

@section('isi')
<style>
    /* Sertakan kembali CSS dari softpay-seller.blade.php atau buat terpisah jika mau */
    .softpay-balance-card {
        background: linear-gradient(135deg, #1e293b 0%, #1e293b 100%);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-radius: 1rem;
        padding: 2rem;
        color: white;
        text-align: center;
    }
</style>

{{-- Hapus main tag di sini, karena sudah ada di layout parent --}}
{{-- main class="flex-1 px-6 py-8 ml-64 bg-[#10172A] min-h-screen" akan diganti --}}
<div class="bg-[#10172A] min-h-screen text-white"> {{-- Tambahkan min-h-screen jika konten pendek --}}
    <div class="max-w-xl mx-auto space-y-8">
        <h1 class="text-3xl font-semibold text-white mb-6">Tarik Dana SoftPay</h1>

        <div class="softpay-balance-card mb-8">
            <h2>Saldo SoftPay Anda Saat Ini</h2>
            <p class="text-4xl">Rp {{ number_format($sellerSoftpayBalance ?? 0, 0, ',', '.') }},00</p> {{-- Perbesar font saldo --}}
        </div>

        <div class="bg-[#1e293b] p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold mb-4 text-white">Form Penarikan Dana</h3>

            @if (session('success'))
                <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('seller.softpay.processWithdraw') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="amount" class="block text-gray-400 text-sm font-bold mb-2">Jumlah Penarikan (Min. Rp 10.000)</label>
                    <input type="number" name="amount" id="amount"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200"
                           min="10000" step="1000" required>
                    @error('amount')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tambahkan field lain untuk detail bank --}}
                <div class="mb-4">
                    <label for="bank_name" class="block text-gray-400 text-sm font-bold mb-2">Nama Bank</label>
                    <input type="text" name="bank_name" id="bank_name"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200"
                           placeholder="Contoh: BCA, Mandiri" required>
                </div>
                <div class="mb-4">
                    <label for="account_number" class="block text-gray-400 text-sm font-bold mb-2">Nomor Rekening</label>
                    <input type="text" name="account_number" id="account_number"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200"
                           placeholder="Contoh: 1234567890" required>
                </div>
                <div class="mb-6">
                    <label for="account_holder_name" class="block text-gray-400 text-sm font-bold mb-2">Nama Pemilik Rekening</label>
                    <input type="text" name="account_holder_name" id="account_holder_name"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200"
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