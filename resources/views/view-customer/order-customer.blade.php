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
    /* Gaya dasar untuk select dan input di tema gelap */
    .bg-gray-700 {
        background-color: #374151;
        /* Darker gray for select backgrounds */
    }

    .bg-gray-800 {
        background-color: #1f2937;
        /* Even darker gray for search input */
    }

    .text-white {
        color: #ffffff;
    }

    .focus\:ring-blue-500:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        /* Blue ring on focus */
    }

    /* Tambahan styling untuk ikon di input search agar vertikal center */
    .absolute.right-3.top-1\/2.-translate-y-1\/2 {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        /* Ensure it spans the full height of the input */
        pointer-events: none;
        /* Make icon unclickable to pass click to input */
    }

    /* Override pointer-events for the button within the search input */
    .absolute.right-3.top-1\/2.-translate-y-1\/2 button {
        pointer-events: auto;
        /* Re-enable click for the button itself */
        height: auto;
        /* Reset height */
    }
    </style>
</head>

<body class="bg-[#10172A] text-white">
    <main class="flex-1 p-6 space-y-6 ml-64">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">My Order</h1>

            <div class="flex items-center space-x-4">
                <a href="{{ route('wishlist-customer.index') }}" class="text-lg hover:text-blue-400">
                    <i class="fa-solid fa-bookmark"></i>
                </a>
            </div>
        </div>

        <form action="{{ route('order-customer') }}" method="GET"
            class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2">
                <label for="status-filter" class="text-gray-300">Filter by</label>
                <select name="status" id="status-filter" onchange="this.form.submit()"
                    class="px-3 py-1 bg-gray-700 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ $selectedStatus == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="completed" {{ $selectedStatus == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="pending" {{ $selectedStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ $selectedStatus == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>

                <label for="category-filter" class="text-gray-300 ml-4">Category</label>
                <select name="category" id="category-filter" onchange="this.form.submit()"
                    class="px-3 py-1 bg-gray-700 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $key => $label)
                    <option value="{{ $key }}" {{ $selectedCategory == $key ? 'selected' : '' }}>{{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="relative w-full max-w-xs">
                <input type="text" name="search" placeholder="Search product" value="{{ $searchQuery }}"
                    class="w-full px-4 py-2 bg-gray-800 text-sm text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button type="submit"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm cursor-pointer">
                    <i class="fa fa-search"></i>
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
            <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-6">
                {{-- PERBAIKAN DI SINI: Kontainer gambar seragam untuk semua produk --}}
                <div class="w-36 h-36 flex-shrink-0 relative overflow-hidden rounded-lg bg-gray-700">
                    {{-- Tambahkan w-36 h-36 untuk ukuran seragam --}}
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
                    <a href="#" class="text-sm text-gray-400">
                        {{ $product->user->name ?? 'Toko Tidak Dikenal' }}
                    </a>
                    <h2 class="font-bold text-lg">{{ $firstDetail->product_name ?? 'Produk Tidak Diketahui' }}</h2>
                    <p class="text-sm text-gray-400 line-clamp-2 mb-2">
                        {{ Str::limit($product->description ?? 'Deskripsi produk tidak tersedia.', 100) }}
                    </p>
                    <a href="{{ route('order-customer.show', $transaction->id) }}"
                        class="text-sm px-3 py-1 border border-gray-500 text-white rounded hover:bg-gray-700"
                        type="button">Check Details</a>
                </div>

                <div class="flex flex-col items-end justify-between h-full ml-auto text-right">
                    <span class="text-green-400 font-semibold mb-9">✔ {{ $transaction->status_label }}</span>
                    <span class="text-orange-400 font-bold text-lg mt-9">Rp.
                        {{ number_format($transaction->total_amount, 2, ',', '.') }}</span>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 p-6">
                Belum ada order yang ditemukan.
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