@extends('layouts.sidebar-seller')

@section('isi')
{{-- Hapus div flex min-h-screen karena sudah ditangani oleh sidebar-seller.blade.php --}}
{{-- Main tag sekarang akan diatur oleh layout parent (sidebar-seller) --}}
{{-- main class="flex-1 p-8 ml-64 bg-[#0f172a] text-white" akan menjadi: --}}
<div class="bg-[#0f172a] text-white min-h-screen"> {{-- Tambahkan min-h-screen jika halaman mungkin pendek --}}
    <h1 class="text-2xl font-bold mb-6">My Product</h1>

    <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <label for="filter-by" class="text-gray-400">Filter by</label>
            <div class="relative">
                <select id="filter-by"
                    class="appearance-none bg-[#1e293b] border border-gray-600 text-white py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Best seller</option>
                    <option>Newest</option>
                    <option>Oldest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3C.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
            <button
                class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded-full text-sm flex items-center gap-1">
                Best seller <i class="fa-solid fa-times text-xs ml-1"></i>
            </button>
            <button class="text-gray-400 hover:text-white flex items-center gap-1">
                <i class="fa-solid fa-sort text-lg"></i>
                <span>Sorting</span>
            </button>
        </div>

        {{-- PERUBAHAN DI SINI: Form untuk Search --}}
        <form action="{{ route('seller.products.index') }}" method="GET" class="relative w-full md:w-1/3">
            <input type="text" name="search" placeholder="Search product"
                value="{{ request('search') }}" {{-- Menjaga nilai input tetap ada setelah pencarian --}}
                class="w-full bg-[#1e293b] border border-gray-600 text-white py-2 pl-10 pr-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {{-- Loop melalui produk yang diterima dari controller --}}
        @forelse($products as $product)
        <div class="bg-[#1e293b] rounded-lg shadow-md p-4 flex flex-col"> {{-- Tambahkan flex flex-col --}}
            <div class="w-full relative" style="padding-top: 100%;">
                {{-- Contoh rasio 3:2, sesuaikan jika ingin 1:1 --}}
                @if($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                    class="absolute inset-0 w-full h-full object-cover rounded-lg mb-4">

                @else
                <div
                    class="absolute inset-0 w-full h-full bg-gray-700 rounded-lg mb-4 flex items-center justify-center text-gray-400">
                    No Image
                </div>
                @endif
            </div>
            <h3 class="text-lg font-semibold text-white mt-4 mb-2 line-clamp-1">{{ $product->name }}</h3>
            {{-- Menggunakan $product->name --}}
            <p class="text-gray-400 text-sm mb-2 line-clamp-2">
                {{ $product->description }} {{-- Menggunakan $product->description --}}
            </p>
            <p class="text-white font-bold text-lg mb-4 mt-auto"> {{-- Tambahkan mt-auto agar harga di bawah --}}
                {{ $product->currency }} {{ number_format($product->price, 0, ',', '.') }}
                {{-- Menampilkan harga dan mata uang --}}
            </p>
            {{-- Tombol Check Details dan Delete --}}
            <div class="flex gap-2">
                <a href="{{ route('seller.products.details', $product->id) }}"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium text-center transition-colors">
                    Check Details
                </a>
                <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-medium text-center transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-400 py-10">
            <p>Tidak ada produk yang ditemukan.</p> {{-- Pesan disesuaikan untuk pencarian --}}
            <a href="{{ route('seller.products.create') }}"
                class="text-blue-500 hover:underline mt-4 inline-block">Tambahkan Produk Sekarang</a>
        </div>
        @endforelse
    </div>

    <div class="fixed bottom-8 right-8">
        <a href="{{ route('seller.products.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg font-semibold transition-colors">
            Add Product
        </a>
    </div>
</div>
@endsection