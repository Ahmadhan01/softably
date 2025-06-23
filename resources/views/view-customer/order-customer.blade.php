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

    <body class="bg-[#10172A] text-white font-sans">
        <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">My Order</h1>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('wishlist-customer.index') }}" class="text-lg hover:text-blue-400">
                        <i class="fa-solid fa-bookmark"></i>
                    </a>
                    {{-- Logo keranjang telah dihapus dari sini sesuai permintaan --}}
                </div>
            </div>

            {{-- Form akan mengirimkan permintaan GET ke rute order-customer untuk filter dan pencarian --}}
            <form action="{{ route('order-customer') }}" method="GET"
                class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-2">
                    {{-- Dropdown Filter Status --}}
                    <label for="status-filter" class="text-gray-300">Filter by</label>
                    <select name="status" id="status-filter" onchange="this.form.submit()"
                        class="px-3 py-1 bg-gray-700 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ $selectedStatus == 'all' ? 'selected' : '' }}>All Status</option>
                        {{-- Loop melalui status yang mungkin atau hardcode jika terbatas --}}
                        {{-- Anda bisa mengambil daftar status dari database jika ada enum, atau dari konstanta di model --}}
                        <option value="completed" {{ $selectedStatus == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ $selectedStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ $selectedStatus == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>

                    {{-- Dropdown Filter Kategori Produk --}}
                    <label for="category-filter" class="text-gray-300 ml-4">Category</label>
                    <select name="category" id="category-filter" onchange="this.form.submit()"
                        class="px-3 py-1 bg-gray-700 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        {{-- Loop melalui kategori yang dilewatkan dari controller --}}
                        @foreach ($categories as $key => $label)
                        <option value="{{ $key }}" {{ $selectedCategory == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Pencarian Produk --}}
                <div class="relative w-full max-w-xs">
                    <input type="text" name="search" placeholder="Search product" value="{{ $searchQuery }}"
                        class="w-full px-4 py-2 bg-gray-800 text-sm text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    {{-- Tombol submit untuk pencarian --}}
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
                $firstDetail = $transaction->details->first();
                // Asumsi setiap TransactionDetail memiliki relasi ke Product
                $product = $firstDetail->product;
                @endphp
                <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-6">
                    <div class="w-48 h-36 rounded-lg bg-white flex-shrink-0 overflow-hidden">
                        {{-- Menggunakan product_image_url dari TransactionDetail --}}
                        <img src="{{ $firstDetail->product_image_url }}"
                            alt="{{ $firstDetail->product_name ?? 'Product Image' }}"
                            class="w-full h-full object-cover rounded-lg" />
                    </div>

                    <div class="flex-1">
                        <a href="#" class="text-sm text-gray-400">
                            {{ $product->seller->name ?? 'Toko Tidak Dikenal' }}
                        </a>
                        <h2 class="font-bold text-lg">{{ $firstDetail->product_name }}</h2>
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
                {{-- Tampilkan pesan jika tidak ada order yang ditemukan --}}
                <div class="text-center text-gray-500 p-6">
                    Belum ada order yang ditemukan.
                </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            <div class="mt-8">
                {{ $orders->links() }} {{-- $orders di sini adalah objek paginator --}}
            </div>
        </main>
    </body>

    </html>
    @endsection