@extends('layouts.sidebar')

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
        min-width: 90px; /* Lebar minimum agar ikon dan teks tidak terlalu sempit */
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
        <h1 class="text-3xl font-semibold text-white">SoftPay</h1>

        <div class="softpay-balance-card">
            <h2>Saldo SoftPay Anda</h2>
            <p>Rp {{ number_format($softpayBalance ?? 0, 0, ',', '.') }},00</p>
            <div class="mt-6 flex justify-center gap-4">
                <a href="{{ route('softpay.topup') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                    Isi Saldo
                </a>
                <a href="{{ route('softpay.withdraw') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                    Tarik Saldo
                </a>
            </div>
        </div>

        <div class="bg-[#1e293b] p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold mb-4 text-white">Aksi Cepat</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
                <a href="{{ route('softpay.pay') }}" class="quick-action-button">
                    <i class="fa-solid fa-qrcode"></i>
                    <span>Bayar</span>
                </a>
                <a href="{{ route('softpay.transfer') }}" class="quick-action-button">
                    <i class="fa-solid fa-exchange-alt"></i>
                    <span>Transfer</span>
                </a>
                <a href="{{ route('softpay.history') }}" class="quick-action-button">
                    <i class="fa-solid fa-history"></i>
                    <span>Riwayat</span>
                </a>
                <a href="{{ route('softpay.promo') }}" class="quick-action-button">
                    <i class="fa-solid fa-tags"></i>
                    <span>Promo</span>
                </a>
                <a href="{{ route('softpay.help') }}" class="quick-action-button">
                    <i class="fa-solid fa-question-circle"></i>
                    <span>Bantuan</span>
                </a>
            </div>
        </div>

        <div class="bg-[#1e293b] p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold mb-4 text-white">Riwayat Transaksi Terbaru</h3>
            <div class="space-y-3">
                @forelse ($recentTransactions as $transaction)
                    <div class="transaction-item">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#2D3A4F] rounded-full flex items-center justify-center text-xl">
                                @if ($transaction['type'] == 'Pembelian')
                                    <i class="fa-solid fa-shopping-cart text-blue-400"></i>
                                @elseif ($transaction['type'] == 'Isi Saldo')
                                    <i class="fa-solid fa-wallet text-green-400"></i>
                                @elseif ($transaction['type'] == 'Tarik Saldo')
                                    <i class="fa-solid fa-money-bill-transfer text-red-400"></i>
                                @elseif ($transaction['type'] == 'Transfer')
                                    <i class="fa-solid fa-paper-plane text-purple-400"></i>
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
                    <p class="text-center text-gray-400">Belum ada transaksi SoftPay.</p>
                @endforelse
            </div>
            @if(count($recentTransactions) > 0)
                <div class="text-center mt-6">
                    <a href="{{ route('softpay.history') }}" class="text-blue-400 hover:underline">Lihat Semua Riwayat</a>
                </div>
            @endif
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    // Anda bisa menambahkan script khusus SoftPay di sini, misalnya untuk:
    // - Animasi saat saldo berubah
    // - Logika untuk halaman top-up/withdraw yang lebih kompleks
    // - Integrasi API untuk transaksi real-time
    document.addEventListener('DOMContentLoaded', function() {
        // Example: Add a subtle animation to the balance on load
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