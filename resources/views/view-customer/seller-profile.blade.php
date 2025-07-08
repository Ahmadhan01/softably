@extends('layouts.sidebar')

@section('isi')
    <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64">
            <a href="{{ url()->previous() }}" class="text-sm text-white hover:underline">
                <i class="fa-solid fa-arrow-left"></i>&nbsp; Kembali
            </a>

            <div class="bg-[#1e293b] p-6 rounded-lg shadow-md mt-4">
                <div class="flex items-center space-x-6 mb-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden flex-shrink-0">
                        <img src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                        <p class="text-gray-400">Email: {{ $user->email }}</p>
                        <p class="text-gray-400">Bergabung sejak: {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <h2 class="text-xl font-semibold mt-8 mb-4 text-white">Produk dari {{ $user->name }}</h2>
                @if($products->isNotEmpty())
                    {{-- PERUBAHAN DI SINI: Ubah grid-cols menjadi lg:grid-cols-4 dan sesuaikan gap --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($products as $product)
                            <div class="bg-[#0f172a] p-3 rounded-lg shadow"> {{-- Kecilkan padding --}}
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover rounded-md mb-3"> {{-- Kecilkan margin bawah gambar --}}
                                <h3 class="font-semibold text-base text-white truncate">{{ $product->name }}</h3> {{-- Kecilkan ukuran teks judul dan tambahkan truncate --}}
                                <p class="text-gray-400 text-xs mt-1">{{ Str::limit($product->description, 70) }}</p> {{-- Kecilkan ukuran teks deskripsi dan batasi lebih pendek --}}
                                <p class="font-bold text-orange-400 text-sm mt-2">Rp. {{ number_format($product->price, 0, ',', '.') }},00</p> {{-- Kecilkan ukuran teks harga --}}
                                <a href="{{ route('view-product.show', $product->id) }}" class="mt-3 inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-xs">Lihat Produk</a> {{-- Kecilkan padding dan ukuran teks tombol --}}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center">Penjual ini belum memiliki produk.</p>
                @endif
            </div>
        </main>
    </div>
@endsection