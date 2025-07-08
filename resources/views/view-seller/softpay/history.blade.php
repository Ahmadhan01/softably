@extends('layouts.sidebar-seller')

@section('isi')
<style>
    /* Sertakan kembali CSS dari softpay-seller.blade.php atau buat terpisah jika mau */
    .transaction-item {
        background-color: #1F2A40;
        padding: 1rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .transaction-item:last-child {
        margin-bottom: 0;
    }

    .transaction-amount.income {
        color: #34d399; /* Hijau untuk pemasukan */
        font-weight: bold;
    }

    .transaction-amount.expense {
        color: #ef4444; /* Merah untuk pengeluaran */
        font-weight: bold;
    }
</style>

{{-- Hapus main tag di sini, karena sudah ada di layout parent --}}
{{-- main class="flex-1 px-6 py-8 ml-64 bg-[#10172A] min-h-screen" akan diganti --}}
<div class="bg-[#10172A] min-h-screen text-white"> {{-- Tambahkan min-h-screen jika konten pendek --}}
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-semibold text-white mb-6">Riwayat Pemasukan SoftPay</h1>

        <div class="bg-[#1e293b] p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold mb-4 text-white">Daftar Transaksi</h3>
            <div class="space-y-3">
                @forelse ($transactions as $transaction)
                    <div class="transaction-item">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#2D3A4F] rounded-full flex items-center justify-center text-xl">
                                @if ($transaction['type'] == 'Pemasukan Penjualan')
                                    <i class="fa-solid fa-hand-holding-dollar text-green-400"></i>
                                @elseif ($transaction['type'] == 'Penarikan Dana')
                                    <i class="fa-solid fa-money-bill-transfer text-red-400"></i>
                                @else
                                    <i class="fa-solid fa-info-circle text-gray-400"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-white">{{ $transaction['description'] }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction['date'] }}</p>
                            </div>
                        </div>
                        <span class="transaction-amount {{ $transaction['amount'] > 0 ? 'income' : 'expense' }}">
                            Rp {{ number_format($transaction['amount'], 0, ',', '.') }},00
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-400">Belum ada riwayat transaksi SoftPay.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $transactions->links() }} {{-- Menampilkan link pagination --}}
            </div>
        </div>
    </div>
</div>
@endsection