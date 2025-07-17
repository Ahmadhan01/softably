@extends('layouts.sidebar-seller')

@section('isi')
<style>
    /* Sertakan kembali CSS dari softpay-seller.blade.php atau buat terpisah jika mau */
    /* RIWAYAT TRANSAKSI ITEM - Diselaraskan dengan softpay-seller.blade.php */
    .transaction-item {
        background-color: #FFFFFF; /* Background item notifikasi jadi putih */
        border: 1px solid #E0E0E0; /* Border abu-abu terang */
        border-radius: 0.5rem; /* rounded-lg */
        padding: 1rem; /* p-4 */
        display: flex;
        align-items: center; /* Sesuaikan alignment jika deskripsi multi-baris */
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

    /* Penyesuaian untuk Deskripsi agar tidak menggeser harga */
    .transaction-description-content {
        flex-grow: 1; /* Kontainer ini akan mengambil ruang yang tersedia */
        min-width: 0; /* Penting! Memungkinkan flex item mengecil lebih dari content aslinya */
        /* Hapus white-space: nowrap; overflow: hidden; text-overflow: ellipsis; agar bisa wrap */
    }

    .transaction-description-content p {
        /* Default p akan wrap, jadi tidak perlu properti tambahan di sini */
    }

</style>

{{-- Kontainer utama untuk halaman --}}
<div class="bg-[#F8FAFC] min-h-screen text-gray-800 p-6 rounded-lg shadow-md"> {{-- Ubah background utama dan teks, tambahkan padding, rounded, shadow --}}
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Riwayat Pemasukan SoftPay</h1> {{-- Ubah warna teks --}}

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200"> {{-- Ubah background menjadi putih, tambahkan shadow dan border --}}
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Daftar Transaksi</h3> {{-- Ubah warna teks --}}
            <div class="space-y-3">
                @forelse ($transactions as $transaction)
                    <div class="transaction-item">
                        <div class="flex items-start gap-3"> {{-- Ubah items-center menjadi items-start agar ikon sejajar dengan baris pertama teks --}}
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-xl flex-shrink-0"> {{-- Tambahkan flex-shrink-0 agar ikon tidak mengecil --}}
                                @if ($transaction['type'] == 'Pemasukan Penjualan')
                                    <i class="fa-solid fa-hand-holding-dollar text-green-500"></i>
                                @elseif ($transaction['type'] == 'Penarikan Dana')
                                    <i class="fa-solid fa-money-bill-transfer text-red-500"></i>
                                @else
                                    <i class="fa-solid fa-info-circle text-gray-500"></i>
                                @endif
                            </div>
                            <div class="transaction-description-content mr-4"> {{-- mr-4 untuk jarak dengan harga --}}
                                <p class="font-medium text-gray-800">{{ $transaction['description'] }}</p>
                                <p class="text-xs text-gray-600">{{ $transaction['date'] }}</p>
                            </div>
                        </div>
                        <span class="transaction-amount {{ $transaction['amount'] > 0 ? 'income' : 'expense' }} flex-shrink-0 whitespace-nowrap"> {{-- Tambahkan whitespace-nowrap agar harga tidak ter-enter --}}
                            Rp {{ number_format($transaction['amount'], 0, ',', '.') }},00
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-600">Belum ada riwayat transaksi SoftPay.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $transactions->links() }} {{-- Menampilkan link pagination --}}
            </div>
        </div>
    </div>
</div>
@endsection