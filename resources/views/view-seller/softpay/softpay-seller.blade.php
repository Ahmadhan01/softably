@extends('layouts.sidebar-seller') {{-- Pastikan path ini benar sesuai lokasi sidebar-seller.blade.php --}}

@section('isi')
<style>
    /* Custom styles for SoftPay specific elements */
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
        color: white; /* Ubah warna saldo menjadi putih agar kontras dengan latar belakang biru */
    }

    /* QUICK ACTION BUTTONS - Ini mungkin tidak digunakan langsung dengan tombol yang sekarang, tapi biarkan dulu */
    .quick-action-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1rem 0.5rem;
        background-color:#E0E7FF; /* Ubah background menjadi biru sangat muda */
        border-radius: 0.75rem;
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        text-decoration: none;
        color: #2563EB; /* Warna teks menjadi biru */
        font-size: 0.875rem;
        min-width: 90px;
        text-align: center;
    }

    .quick-action-button:hover {
        background-color:#C3DAFE; /* Ubah hover background */
        transform: translateY(-2px);
        color: #1D4ED8; /* Ubah hover teks */
    }

    .quick-action-button i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #2563EB; /* Warna ikon aksi cepat menjadi biru */
    }

    /* RIWAYAT TRANSAKSI ITEM */
    .transaction-item {
        background-color: #FFFFFF; /* Ubah background menjadi putih */
        border: 1px solid #E0E0E0; /* Border abu-abu terang */
        padding: 1rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05); /* Sedikit shadow */
    }

    .transaction-item:last-child {
        margin-bottom: 0;
    }

    .transaction-amount.income {
        color: #10B981; /* Hijau yang lebih cerah untuk pemasukan */
        font-weight: bold;
    }

    .transaction-amount.expense {
        color: #EF4444; /* Merah untuk pengeluaran */
        font-weight: bold;
    }

</style>

{{-- Kontainer utama untuk halaman --}}
<div class="bg-[#F8FAFC] min-h-screen text-gray-800 p-6 rounded-lg shadow-md"> {{-- Ubah background utama dan teks, tambahkan padding, rounded, shadow --}}
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-semibold text-gray-800">SoftPay Penjual</h1> {{-- Ubah warna teks --}}

        <div class="softpay-balance-card">
            <h2>Saldo SoftPay Anda</h2>
            {{-- Variabel $sellerSoftpayBalance akan disediakan oleh SellerSoftpayController --}}
            <p>Rp {{ number_format($sellerSoftpayBalance ?? 0, 0, ',', '.') }},00</p>
            <div class="mt-6 flex justify-center gap-4">
                {{-- Tombol Aksi Cepat untuk Penjual --}}
                <a href="{{ route('seller.softpay.withdraw') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200"> {{-- Ubah warna tombol menjadi biru --}}
                    Tarik Dana
                </a>
                <a href="{{ route('seller.softpay.history') }}" class="bg-white border border-blue-600 text-blue-600 font-semibold py-2 px-6 rounded-lg transition duration-200 hover:bg-blue-50"> {{-- Ubah warna tombol menjadi putih dengan border biru --}}
                    Riwayat Pemasukan
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Riwayat Pemasukan Terbaru</h3> {{-- Ubah warna teks --}}
            <div class="space-y-3">
                {{-- Variabel $recentSellerTransactions akan disediakan oleh SellerSoftpayController --}}
                @forelse ($recentSellerTransactions as $transaction)
                    <div class="transaction-item">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-xl"> {{-- Ubah background ikon --}}
                                @if ($transaction['type'] == 'Pemasukan Penjualan')
                                    <i class="fa-solid fa-hand-holding-dollar text-green-500"></i> {{-- Hijau yang lebih cerah --}}
                                @elseif ($transaction['type'] == 'Penarikan Dana')
                                    <i class="fa-solid fa-money-bill-transfer text-red-500"></i> {{-- Merah yang lebih cerah --}}
                                @else
                                    <i class="fa-solid fa-info-circle text-gray-500"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $transaction['description'] }}</p> {{-- Ubah warna teks --}}
                                <p class="text-xs text-gray-600">{{ $transaction['date'] }}</p> {{-- Ubah warna teks --}}
                            </div>
                        </div>
                        <span class="transaction-amount {{ $transaction['amount'] > 0 ? 'income' : 'expense' }}">
                            Rp {{ number_format($transaction['amount'], 0, ',', '.') }},00
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-600">Belum ada riwayat pemasukan SoftPay.</p> {{-- Ubah warna teks --}}
                @endforelse
            </div>
            @if(count($recentSellerTransactions) > 0)
                <div class="text-center mt-6">
                    <a href="{{ route('seller.softpay.history') }}" class="text-blue-600 hover:underline">Lihat Semua Riwayat Pemasukan</a> {{-- Ubah warna teks --}}
                </div>
            @endif
        </div>

    </div>
</div>
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