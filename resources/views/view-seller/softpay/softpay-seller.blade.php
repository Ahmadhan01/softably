@extends('layouts.sidebar-seller') {{-- Pastikan path ini benar sesuai lokasi sidebar-seller.blade.php --}}

@section('isi')
<style>
    /* Custom styles for SoftPay specific elements */
    .softpay-balance-card {
        background: linear-gradient(135deg, #1e293b 0%, #1e293b 100%);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-radius: 1rem;
        padding: 2rem;
        color: white;
        text-align: center;
    }

    .softpay-balance-card h2 {
        font-size: 1.2rem;
        color: #cbd5e1;
    }

    .softpay-balance-card p {
        font-size: 3rem; /* Large font for balance */
        font-weight: bold;
        margin-top: 0.5rem;
        color: #f59e0b; /* Aksen warna emas/oranye */
    }

    .quick-action-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1rem 0.5rem;
        background-color:rgb(45, 60, 90);
        border-radius: 0.75rem;
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        text-decoration: none;
        color: #cbd5e1;
        font-size: 0.875rem;
        min-width: 90px;
        text-align: center;
    }

    .quick-action-button:hover {
        background-color:rgb(50, 81, 131);
        transform: translateY(-2px);
        color: white;
    }

    .quick-action-button i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #6ee7b7; /* Warna ikon aksi cepat */
    }

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

<main class="flex-1 px-6 py-8 ml-64 bg-[#10172A] min-h-screen">
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-semibold text-white">SoftPay Penjual</h1>

        <div class="softpay-balance-card">
            <h2>Saldo SoftPay Anda</h2>
            {{-- Variabel $sellerSoftpayBalance akan disediakan oleh SellerSoftpayController --}}
            <p>Rp {{ number_format($sellerSoftpayBalance ?? 0, 0, ',', '.') }},00</p>
            <div class="mt-6 flex justify-center gap-4">
                {{-- Tombol Aksi Cepat untuk Penjual --}}
                <a href="{{ route('seller.softpay.withdraw') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                    Tarik Dana
                </a>
                <a href="{{ route('seller.softpay.history') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                    Riwayat Pemasukan
                </a>
            </div>
        </div>

        <div class="bg-[#1e293b] p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold mb-4 text-white">Riwayat Pemasukan Terbaru</h3>
            <div class="space-y-3">
                {{-- Variabel $recentSellerTransactions akan disediakan oleh SellerSoftpayController --}}
                @forelse ($recentSellerTransactions as $transaction)
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
                    <p class="text-center text-gray-400">Belum ada riwayat pemasukan SoftPay.</p>
                @endforelse
            </div>
            @if(count($recentSellerTransactions) > 0)
                <div class="text-center mt-6">
                    <a href="{{ route('seller.softpay.history') }}" class="text-blue-400 hover:underline">Lihat Semua Riwayat Pemasukan</a>
                </div>
            @endif
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const softpayBalanceElement = document.querySelector('.softpay-balance-card p');
        if (softpayBalanceElement) {
            softpayBalanceElement.style.opacity = 0;
            softpayBalanceElement.style.transform = 'translateY(20px)';
            setTimeout(() => {
                softpayBalanceElement.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                softpayBalanceElement.style.opacity = 1;
                softpayBalanceElement.style.transform = 'translateY(0)';
            }, 100);
        }
    });
</script>
@endpush