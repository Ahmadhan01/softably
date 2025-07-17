@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    {{-- Tambahkan CSS kustom jika diperlukan, misalnya untuk styling select atau input search --}}
    <style>
    /* Gaya dasar untuk select dan input di tema terang */
    .filter-select { /* Gaya yang sama seperti di produk-customer.blade.php */
        background-color: #FFFFFF;
        border: 1px solid #D0D0D0;
        color: #333333;
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        width: 180px; /* Sesuaikan lebar */
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill="%23333333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 1em;
        padding-right: 2rem;
    }

    /* Untuk search input */
    .search-input {
        background-color: #F8FAFC; /* Background input search sama dengan body utama */
        border: 1px solid #D0D0D0; /* Border abu-abu terang */
        color: #333333; /* Teks gelap */
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        width: 100%;
        outline: none; /* Hapus outline default */
    }
    .search-input:focus {
        border-color: #2563EB; /* Border biru saat fokus */
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2); /* Sedikit shadow biru saat fokus */
    }

    /* Search icon dalam input */
    .search-icon {
        color: #6B7280; /* Warna ikon abu-abu gelap */
    }


    /* Override pointer-events for the button within the search input (pastikan ini masih relevan) */
    .absolute.right-3.top-1\/2.-translate-y-1\/2 button {
        pointer-events: auto;
        height: auto;
    }
    </style>
</head>

<body class="bg-[#F8FAFC] text-[#333333]"> <main class="flex-1 p-6 space-y-6 ml-64 bg-[#F8FAFC]"> <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">My Order</h1> {{-- Bagian ini mungkin tidak diperlukan lagi jika search dipindahkan ke form filter utama --}}
            {{-- Namun, jika ini untuk ikon wishlist di header halaman My Order, pertahankan dan sesuaikan warnanya --}}
            <div class="flex items-center space-x-4">
                <a href="{{ route('wishlist-customer.index') }}" class="text-[#2563EB] text-lg hover:text-[#3B82F6]"> <i class="fa-solid fa-bookmark"></i>
                </a>
            </div>
        </div>

        <form action="{{ route('order-customer') }}" method="GET"
            class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-lg shadow-md"> <div class="flex items-center gap-2">
                <label for="status-filter" class="text-gray-600">Filter by</label> <select name="status" id="status-filter" onchange="this.form.submit()"
                    class="filter-select"> <option value="all" {{ $selectedStatus == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="completed" {{ $selectedStatus == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="pending" {{ $selectedStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ $selectedStatus == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>

                <label for="category-filter" class="text-gray-600 ml-4">Category</label> <select name="category" id="category-filter" onchange="this.form.submit()"
                    class="filter-select"> <option value="">All Categories</option>
                    @foreach ($categories as $key => $label)
                    <option value="{{ $key }}" {{ $selectedCategory == $key ? 'selected' : '' }}>{{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="relative w-full max-w-xs">
                <input type="text" name="search" placeholder="Search product" value="{{ $searchQuery }}"
                    class="search-input" /> <button type="submit"
                    class="absolute right-3 top-1/2 -translate-y-1/2 search-icon cursor-pointer"> <i class="fa fa-search"></i>
                </button>
            </div>
        </form>

        <div class="space-y-4">
            {{-- Loop melalui setiap transaksi yang diterima dari controller --}}
            @forelse ($orders as $transaction) {{-- $orders di sini sebenarnya adalah koleksi Transaction --}}
            @php
            // Ambil detail transaksi pertama untuk ditampilkan di ringkasan order card
            // Pastikan transaction->details tidak kosong sebelum mengaksesnya
            $firstDetail = $transaction->details->first();
            $product = $firstDetail ? $firstDetail->product : null;
            @endphp
            <div class="bg-white p-4 rounded-lg flex items-center gap-6 shadow-sm border border-gray-200"> {{-- PERBAIKAN DI SINI: Kontainer gambar seragam untuk semua produk --}}
                <div class="w-36 h-36 flex-shrink-0 relative overflow-hidden rounded-lg bg-gray-100 border border-gray-300"> {{-- Tambahkan w-36 h-36 untuk ukuran seragam --}}
                    @if($product && $product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    @else
                    {{-- Placeholder jika tidak ada gambar produk --}}
                    <div class="absolute inset-0 w-full h-full flex items-center justify-center text-gray-400 text-sm">
                        No Image
                    </div>
                    @endif
                </div>

                <div class="flex-1">
                    <a href="#" class="text-sm text-gray-600"> {{ $product->user->name ?? 'Toko Tidak Dikenal' }}
                    </a>
                    <h2 class="font-bold text-lg text-gray-900">{{ $firstDetail->product_name ?? 'Produk Tidak Diketahui' }}</h2> <p class="text-sm text-gray-600 line-clamp-2 mb-2"> {{ Str::limit($product->description ?? 'Deskripsi produk tidak tersedia.', 100) }}
                    </p>
                    <a href="{{ route('order-customer.show', $transaction->id) }}"
                        class="text-sm px-3 py-1 border border-gray-300 text-gray-700 rounded hover:bg-gray-200">Check Details</a> </div>

                <div class="flex flex-col items-end justify-between h-full ml-auto text-right">
                    <span class="text-green-600 font-semibold mb-9">✔ {{ $transaction->status_label }}</span> <span class="text-[#2563EB] font-bold text-lg mt-9">Rp. {{ number_format($transaction->total_amount, 2, ',', '.') }}</span>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-600 p-6"> Belum ada order yang ditemukan.
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    </main>
</body>

</html>
@endsection