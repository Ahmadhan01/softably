@extends('layouts.sidebar')

@section('isi')
<style>
    /* Custom styles for SoftPay specific elements */
    .softpay-balance-card {
        background: #FFFFFF; /* Background card saldo jadi putih */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow lebih ringan */
        border-radius: 1rem;
        padding: 2rem;
        color: #333333; /* Warna teks jadi gelap */
        text-align: center;
        border: 1px solid #E0E0E0; /* Border abu-abu terang */
    }

    .softpay-balance-card h2 {
        font-size: 1.2rem;
        color: #6B7280; /* Warna teks judul saldo jadi abu-abu gelap */
    }

    .softpay-balance-card p {
        font-size: 3rem; /* Large font for balance */
        font-weight: bold;
        margin-top: 0.5rem;
        color: #2563EB; /* Saldo jadi warna biru utama */
    }

    /* Aksi Cepat (jika dikembalikan) */
    .quick-action-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1rem 0.5rem;
        background-color: #F3F4F6; /* Background aksi cepat jadi abu-abu sangat terang */
        border-radius: 0.75rem;
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        text-decoration: none;
        color: #6B7280; /* Teks aksi cepat jadi abu-abu gelap */
        font-size: 0.875rem;
        min-width: 90px;
        text-align: center;
        border: 1px solid #D1D5DB; /* Border abu-abu terang */
    }

    .quick-action-button:hover {
        background-color: #E5E7EB; /* Hover aksi cepat jadi abu-abu lebih terang */
        transform: translateY(-2px);
        color: #333333; /* Teks hover aksi cepat jadi gelap */
    }

    .quick-action-button i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #2563EB; /* Warna ikon aksi cepat jadi biru */
    }

    .transaction-item {
        background-color: #FFFFFF; /* Background item transaksi jadi putih */
        padding: 1rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        border: 1px solid #E0E0E0; /* Border abu-abu terang */
        box-shadow: 0 1px 3px rgba(0,0,0,0.05); /* Sedikit shadow */
    }

    .transaction-item:last-child {
        margin-bottom: 0;
    }

    .transaction-amount.income {
        color: #16A34A; /* Hijau yang lebih gelap untuk pemasukan */
        font-weight: bold;
    }

    .transaction-amount.expense {
        color: #DC2626; /* Merah yang lebih gelap untuk pengeluaran */
        font-weight: bold;
    }

</style>

<main class="flex-1 px-6 py-8 ml-64 bg-[#F8FAFC] min-h-screen"> <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-semibold text-gray-900">SoftPay</h1> <div class="softpay-balance-card">
            <h2>Saldo SoftPay Anda</h2>
            <p>Rp {{ number_format($softpayBalance ?? 0, 0, ',', '.') }},00</p>
            <div class="mt-6 flex justify-center gap-4">
                <a href="{{ route('softpay.topup') }}" class="bg-[#2563EB] hover:bg-[#3B82F6] text-white font-semibold py-2 px-6 rounded-lg transition duration-200"> Isi Saldo
                </a>
                <a href="{{ route('softpay.withdraw') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition duration-200"> Tarik Saldo
                </a>
            </div>
        </div>

        {{-- Bagian "Aksi Cepat" telah dihapus dari sini --}}
        {{-- <div class="bg-[#1e293b] p-6 rounded-xl shadow-md">
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
        </div> --}}

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200"> <h3 class="text-xl font-semibold mb-4 text-gray-800">Riwayat Transaksi Terbaru</h3> <div class="space-y-3">
                @forelse ($recentTransactions as $transaction)
                    <div class="transaction-item">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-xl border border-gray-200"> @if ($transaction['type'] == 'Pembelian')
                                    <i class="fa-solid fa-shopping-cart text-[#2563EB]"></i> @elseif ($transaction['type'] == 'Isi Saldo')
                                    <i class="fa-solid fa-wallet text-[#16A34A]"></i> @elseif ($transaction['type'] == 'Tarik Saldo')
                                    <i class="fa-solid fa-money-bill-transfer text-[#DC2626]"></i> @elseif ($transaction['type'] == 'Transfer')
                                    <i class="fa-solid fa-paper-plane text-[#7C3AED]"></i> @else
                                    <i class="fa-solid fa-info-circle text-gray-500"></i> @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $transaction['description'] }}</p> <p class="text-xs text-gray-500">{{ $transaction['date'] }}</p> </div>
                        </div>
                        <span class="transaction-amount {{ $transaction['amount'] > 0 ? 'income' : 'expense' }}">
                            Rp {{ number_format($transaction['amount'], 0, ',', '.') }},00
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-600">Belum ada transaksi SoftPay.</p> @endforelse
            </div>
            @if(count($recentTransactions) > 0)
                <div class="text-center mt-6">
                    <a href="{{ route('softpay.history') }}" class="text-blue-600 hover:underline">Lihat Semua Riwayat</a> </div>
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